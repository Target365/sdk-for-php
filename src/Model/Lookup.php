<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Exception\ApiClientException;

class Lookup extends AbstractModel
{
    protected $created;
    protected $msisdn;
    protected $landline;
    protected $firstName;
    protected $middleName;
    protected $lastName;
    protected $companyName;
    protected $companyOrgNo;
    protected $streetName;
    protected $streetNumber;
    protected $streetLetter;
    protected $zipCode;
    protected $city;
    protected $gender;
    protected $dateOfBirth;
    protected $age;
    protected $deceasedDate;

    protected function attributes(): array
    {
        return [
            'created',
            'msisdn',
            'landline',
            'firstName',
            'middleName',
            'lastName',
            'companyName',
            'companyOrgNo',
            'streetName',
            'streetNumber',
            'streetLetter',
            'zipCode',
            'city',
            'gender',
            'dateOfBirth',
            'age',
            'deceasedDate',
        ];
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return null;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated(?string $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getMsisdn(): string
    {
        return $this->msisdn;
    }

    public function setMsisdn(string $msisdn): self
    {
        $this->msisdn = $msisdn;
        return $this;
    }

    public function getLandline() : ?string
    {
        return $this->landline;
    }

    public function setLandline(?string $landline): self
    {
        $this->landline = $landline;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getCompanyOrgNo(): ?string
    {
        return $this->companyOrgNo;
    }

    public function setCompanyOrgNo(?string $companyOrgNo): self
    {
        $this->companyOrgNo = $companyOrgNo;
        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(?string $streetName): self
    {
        $this->streetName = $streetName;
        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    public function getStreetLetter(): ?string
    {
        return $this->streetLetter;
    }

    public function setStreetLetter(?string $streetLetter): self
    {
        $this->streetLetter = $streetLetter;
        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getDeceasedDate(): ?string
    {
        return $this->deceasedDate;
    }

    public function setDeceasedDate(?string $deceasedDate): self
    {
        $this->deceasedDate = $deceasedDate;
        return $this;
    }
}
