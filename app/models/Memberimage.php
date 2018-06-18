<?php

class Memberimage extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var integer
     * @Column(column="memberid", type="integer", length=11, nullable=true)
     */
    protected $memberid;

    /**
     *
     * @var string
     * @Column(column="description", type="string", length=30, nullable=true)
     */
    protected $description;

    /**
     *
     * @var string
     * @Column(column="imagefile", type="string", nullable=true)
     */
    protected $imagefile;

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
     * Method to set the value of field memberid
     *
     * @param integer $memberid
     * @return $this
     */
    public function setMemberid($memberid)
    {
        $this->memberid = $memberid;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field imagefile
     *
     * @param string $imagefile
     * @return $this
     */
    public function setImagefile($imagefile)
    {
        $this->imagefile = $imagefile;

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
     * Returns the value of field memberid
     *
     * @return integer
     */
    public function getMemberid()
    {
        return $this->memberid;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value of field imagefile
     *
     * @return string
     */
    public function getImagefile()
    {
        return $this->imagefile;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tennisClub");
        $this->setSource("memberImage");
        $this->belongsTo('memberid', '\Member', 'id', ['alias' => 'Member']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'memberImage';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Memberimage[]|Memberimage|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Memberimage|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
