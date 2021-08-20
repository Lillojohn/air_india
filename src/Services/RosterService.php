<?php

namespace App\Services;

use App\Entity\RosterDay;
use DOMDocument;
use DOMXPath;

class RosterService
{
    public const DATE = "date";
    public const START_TIME = "startTime";
    public const END_TIME = "endTime";

    private RosterActivityService $rosterActivityService;

    public function __construct(RosterActivityService $rosterActivityService)
    {
        $this->rosterActivityService = $rosterActivityService;
    }

    public function getHtmlContentToRosterDays(string $htmlFile): ?array
    {
        if (!file_exists($htmlFile) || !is_readable($htmlFile)) {
            return null;
        }

        $columns = $this->htmlTableInColumnArray($htmlFile);
        $filterColumns = $this->filterColumn($columns);
        return $this->makeRosterDays($filterColumns);
    }

    /**
     * @param array $filterColumns
     * @return array
     */
    private function makeRosterDays(array $filterColumns): array
    {
        $roster = [];
        foreach ($filterColumns as $column) {
            if (!$column[self::DATE]) {
                continue;
            }

            $column = $this->setStartEndTimeInColumn($column);
            $rosterDay = new RosterDay($column[self::DATE], $column[self::START_TIME], $column[self::END_TIME]);

            foreach ($column as $activity) {
                if (!is_array($activity)) {
                    continue;
                }

                $rosterActivity = $this->rosterActivityService->makeRosterActivity($activity);
                if ($rosterActivity === null) {
                    continue;
                }

                $rosterDay->addRosterActivities($rosterActivity);
            }
            $roster[] = $rosterDay;
        }

        return $roster;
    }

    private function setStartEndTimeInColumn(array $column): array
    {
        $startTime = null;
        $endTime = null;
        $firstTimeIndex = array_search(1, array_map(array($this, 'getTime'), $column[1]));
        if ($firstTimeIndex !== false) {
            $startTime = $column[1][$firstTimeIndex];
            array_splice($column[1], $firstTimeIndex, 1);
            $endTime = $column[count($column) - 1][count($column[count($column) - 1]) - 1];
            array_splice($column[count($column) - 1], count($column[count($column) - 1]) - 1, 1);
        }

        $column[self::START_TIME] = $startTime;
        $column[self::END_TIME] = $endTime;

        return $column;
    }

    private function getTime(string $time): bool
    {
        return preg_match('/^[0-9]{2}[:][0-9]{2}$/', $time);
    }

    private function htmlTableInColumnArray(string $htmlFile): array
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTMLFile($htmlFile);
        $content = new DOMXpath($dom);

        $columns = [];
        foreach ($content->query('//tr') as $tr) {
            $trDom = new DOMDocument();
            $trDom->loadHTML($tr->C14N());
            $tr = new DOMXpath($trDom);
            foreach ($tr->query('//td') as $key => $td) {
                $columns[$key][] = $td->nodeValue;
            }
        }

        return $columns;
    }

    private function filterColumn(array $columns): array
    {
        $filterColumns = [];
        foreach ($columns as $key => $column) {
            $previousValueMatch = false;
            $count = 1;
            foreach ($column as $value) {
                if (preg_match("/[a-zA-Z]{3}[0-9]{2}[a-zA-Z]{3}/", $value)) {
                    $filterColumns[$key][self::DATE] = $value;
                    $previousValueMatch = true;
                    continue;
                }

                if (preg_match("/(^[A-Z\/]{3,4}$)|^[0-9]{3,4}$|(^[0-9]{2}[:][0-9]{2}$)/", $value)) {
                    if (
                        $previousValueMatch === false &&
                        preg_match("/^[0-9]{2}[:][0-9]{2}$/", $value)
                    ) {
                        continue;
                    }

                    if ($previousValueMatch === false) {
                        $filterColumns[$key][] = "";
                        $count++;
                        $filterColumns[$key][$count] = [];
                    }

                    $filterColumns[$key][$count][] = $value;
                    $previousValueMatch = true;
                    continue;
                }

                $previousValueMatch = false;
            }
        }

        return $filterColumns;
    }
}
