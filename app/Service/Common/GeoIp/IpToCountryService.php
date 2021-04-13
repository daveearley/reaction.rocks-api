<?php

declare(strict_types=1);

namespace App\Service\Common\GeoIp;

use Exception;
use GeoIp2\Database\Reader;

class IpToCountryService implements IpToCountryServiceInterface
{
    private const ASN_DATABASE = __DIR__ . '/../../../../../data/geoip/GeoLite2-ASN.mmdb';
    private const CITY_DATABASE = __DIR__ . '/../../../../data/geoip/GeoLite2-City.mmdb';

    /** @var $ipAddress */
    private $ipAddress;

    /** @var Reader */
    private $cityReader;

    /** @var Reader */
    private $asnReader;

    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return null|string
     */
    public function getOrganisation(): ?string
    {
        try {
            $record = $this->getAsnReader()->asn($this->ipAddress);
        } catch (Exception $e) {
            return null;
        }

        return $record->autonomousSystemOrganization;
    }

    /**
     * @return Reader
     */
    private function getAsnReader(): Reader
    {
        if ($this->asnReader instanceof Reader) {
            return $this->asnReader;
        }

        $this->asnReader = new Reader(self::ASN_DATABASE);

        return $this->asnReader;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->getCityRecord('city');
    }

    /**
     * @param string $recordType
     *
     * @return null|string
     */
    private function getCityRecord(string $recordType): ?string
    {
        try {
            $record = $this->getCityReader()->city($this->ipAddress);
        } catch (Exception) {
            return null;
        }

        return match ($recordType) {
            'latitude' => (string)$record->location->latitude,
            'longitude' => (string)$record->location->longitude,
            'country' => (string)$record->country->name,
            'countryCode' => (string)$record->country->isoCode,
            'city' => (string)$record->city->name,
            'continent' => (string)$record->continent->name,
            default => null,
        };
    }

    /**
     * @return Reader
     */
    private function getCityReader(): Reader
    {
        if ($this->cityReader instanceof Reader) {
            return $this->cityReader;
        }

        $this->cityReader = new Reader(self::CITY_DATABASE);

        return $this->cityReader;
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->getCityRecord('country');
    }

    /**
     * @return null|string
     */
    public function getCountryCode(): ?string
    {
        return $this->getCityRecord('countryCode');
    }

    /**
     * @return null|string
     */
    public function getLatitude(): ?string
    {
        return $this->getCityRecord('latitude');
    }

    /**
     * @return null|string
     */
    public function getLongitude(): ?string
    {
        return $this->getCityRecord('longitude');
    }

    /**
     * @return null|string
     */
    public function getContinent(): ?string
    {
        return $this->getCityRecord('continent');
    }
}