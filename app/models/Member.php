<?php

class Member extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(column="firstname", type="string", length=30, nullable=true)
     */
    public $firstname;

    /**
     *
     * @var string
     * @Column(column="surname", type="string", length=30, nullable=true)
     */
    public $surname;

    /**
     *
     * @var string
     * @Column(column="membertype", type="string", length=6, nullable=true)
     */
    public $membertype;

    /**
     *
     * @var string
     * @Column(column="dateofbirth", type="string", nullable=true)
     */
    public $dateofbirth;

    /**
     *
     * @var string
     * @Column(column="memberpic", type="string", nullable=true)
     */
    public $memberpic;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field firstname
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Method to set the value of field surname
     *
     * @param string $surname
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Method to set the value of field membertype
     *
     * @param string $membertype
     * @return $this
     */
    public function setMembertype($membertype)
    {
        $this->membertype = $membertype;

        return $this;
    }

    /**
     * Method to set the value of field dateofbirth
     *
     * @param string $dateofbirth
     * @return $this
     */
    public function setDateofbirth($dateofbirth)
    {
        $this->dateofbirth = $dateofbirth;

        return $this;
    }

    /**
     * Method to set the value of field memberpic
     *
     * @param string $memberpic
     * @return $this
     */
    public function setMemberpic($memberpic)
    {
        $this->memberpic = $memberpic;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Returns the value of field surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Returns the value of field membertype
     *
     * @return string
     */
    public function getMembertype()
    {
        return $this->membertype;
    }

    /**
     * Returns the value of field dateofbirth
     *
     * @return string
     */
    public function getDateofbirth()
    {
        return $this->dateofbirth;
    }

    /**
     * Returns the value of field memberpic
     *
     * @return string
     */
    public function getMemberpic()
    {
        return $this->memberpic;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("Member");
        $this->hasMany('id', 'Memberimage', 'memberid', ['alias' => 'Memberimage']);

    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Member[]|Member|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Member|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function getAge()
    {
        $dob = new DateTime($this->dateOfBirth);
        $today = new DateTime();
        $interval = $today->diff($dob);
        return $interval->format("%y");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'member';
    }

}
