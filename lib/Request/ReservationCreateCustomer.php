<?php

namespace Tablebooker\Request;

use bar\baz\source_with_namespace;
use Tablebooker\Error;

class ReservationCreateCustomer implements RequestResource
{
    protected $id;              // string   Obfuscated id of an existing customer where you want to create the reservation for.
    protected $token;           // string
    protected $type;            // string
    protected $company;         // string
    protected $vat;             // string
    protected $lastname;        // string
    protected $firstname;       // string
    protected $email;           // string
    protected $phone;           // string
    protected $postal;          // string
    protected $language;        // string
    protected $gender;          // string
    protected $country;         // string   Country of the customer (e.g. BE, NL, FR, ...).
    protected $notes;           // string   Notes added by the customer about the reservation. If this is used, customer_emails should be filled in.
    protected $externalId;

    /**
     * Creates a new Customer entity that will be used as an attribute of a ReservationCreate entity.
     *
     * @param $id
     * @param $token
     * @param $type
     * @param $company
     * @param $vat
     * @param $lastname
     * @param $firstname
     * @param $email
     * @param $phone
     * @param $postal
     * @param $language
     * @param $gender
     * @param $country
     * @param $notes
     * @param $externalId
     */
    public function __construct(
        $id=null,
        $token=null,
        $type=null,
        $company=null,
        $vat=null,
        $lastname=null,
        $firstname=null,
        $email=null,
        $phone=null,
        $postal=null,
        $language=null,
        $gender=null,
        $country=null,
        $notes=null,
        $externalId=null
    ) {
        $this->id = !empty($id)?$id:null;
        $this->token = $token;
        $this->type = $type;
        $this->company = $company;
        $this->vat = $vat;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->phone = $phone;
        $this->postal = $postal;
        $this->language = $language;
        $this->gender = $gender;
        $this->country = $country;
        $this->notes = $notes;
        $this->externalId = $externalId;
    }

    public function validate(){
        $invalidFields = $this->getInvalidFields();

        if (!empty($invalidFields)){
            $message = 'Invalid data in ReservationCreateCustomer request object: ' . json_encode($invalidFields) . '.';
            throw new Error\InvalidRequest($message);
            return false;
        }

        return true;
    }

    public function getInvalidFields(){
        $invalidFields = array();

        // Important:
        // If field validation is added here, make sure to add 'customer_' in front of the array key, to make
        // sure it doesn't override validation errors from its parent (ReservationCreate).
        /*
        if (!isset($this->id)){
            $invalidFields['customer_id'] = $this->id;
        }
        */

        return $invalidFields;
    }

    public function getParams()
    {
        $params = array(
            'customer_id' => $this->id,
            'customer_token' => $this->token,
            'customer_type' => $this->type,
            'customer_company' => $this->company,
            'customer_vat' => $this->vat,
            'customer_lastname' => $this->lastname,
            'customer_firstname' => $this->firstname,
            'customer_email' => $this->email,
            'customer_phone' => $this->phone,
            'customer_postal' => $this->postal,
            'customer_language' => $this->language,
            'customer_gender' => $this->gender,
            'customer_country' => $this->country,
            'customer_notes' => $this->notes,
            'external_customer_id' => $this->externalId,
        );

        $params = array_filter($params, function($val) {
            return isset($val);
        });

        return $params;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param null $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param null $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param null $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @param null $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @param null $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @param null $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param null $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param null $postal
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;
    }

    /**
     * @param null $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param null $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @param null $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param null $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @param null $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
    }



}