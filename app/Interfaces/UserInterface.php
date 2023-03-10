<?php

namespace App\Interfaces;

interface UserInterface
{
    /**
     * This method is for show user list
     *
     */
    public function listAll();
     /**
     * This method is for show user details
     * @param  $id
     *
     */
    public function listById($id);
    /**
     * This method is for create user
     *
     */
    public function create(array $data);
    /**
     * This method is for user update
     *
     *
     */
    public function update($id, $data);
    /**
     * This method is for update user status
     * @param  $id
     *
     */
    public function toggle(array $params);
    
    /**
     * This method is for user delete
     * @param  $id
     *
     */
    public function delete($id);

    public function getSearchUser(string $term);
   
}
