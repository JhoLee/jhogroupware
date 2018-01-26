<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-26
 * Time: 오전 11:38
 */


class Member
{

    protected $id = '-1';
    protected $name = '_default';
    protected $team = '_default';
    public $mobile = '1541';
    public $birthday = '2018.01.26';
    protected $permission = -1;

    /**
     * Member constructor.
     * @param $id : m_id
     * @param $name : m_name
     * @param $team : t_team
     * @param $mobile : m_mobile
     * @param $birthday : m_birthday
     * @param $permission : m_permission
     */

    public function __construct($id, $name, $team, $mobile, $birthday, $permission)
    {


        $this->id = $id;
        $this->name = $name;
        $this->team = $team;
        $this->mobile = $mobile;
        $this->birthday = $birthday;
        $this->permission = $permission;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function getPermission()
    {
        return $this->permission;
    }


}