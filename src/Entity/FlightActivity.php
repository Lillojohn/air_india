<?php

namespace App\Entity;

class FlightActivity extends RosterActivity
{
    private int $flightNumber;

    private string $departureTime;

    private string $departureAirport;

    private string $arrivalTime;

    private string $arrivalAirport;

    public function __construct(
        string $activityType,
        int $flightNumber,
        string $departureTime,
        string $departureAirport,
        string $arrivalTime,
        string $arrivalAirport
    ) {
        parent::__construct($activityType);
        $this->flightNumber = $flightNumber;
        $this->departureTime = $departureTime;
        $this->departureAirport = $departureAirport;
        $this->arrivalTime = $arrivalTime;
        $this->arrivalAirport = $arrivalAirport;
    }

    /**
     * @return int
     */
    public function getFlightNumber(): int
    {
        return $this->flightNumber;
    }

    /**
     * @return string
     */
    public function getDepartureTime(): string
    {
        return $this->departureTime;
    }

    /**
     * @return string
     */
    public function getDepartureAirport(): string
    {
        return $this->departureAirport;
    }

    /**
     * @return string
     */
    public function getArrivalTime(): string
    {
        return $this->arrivalTime;
    }

    /**
     * @return string
     */
    public function getArrivalAirport(): string
    {
        return $this->arrivalAirport;
    }
}
