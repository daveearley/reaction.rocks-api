<?php

namespace App\Service\Common\GeoIp;

interface IpToCountryServiceInterface
{
    public function setIpAddress(string $ipAddress): void;

    public function getCity(): ?string;

    public function getCountry(): ?string;

    public function getCountryCode(): ?string;

    public function getContinent(): ?string;

    public function getOrganisation(): ?string;

    public function getLatitude(): ?string;

    public function getLongitude(): ?string;
}