<?php

namespace App\Interfaces;

interface CustomerInterface
{
    
    /**
     * This method is to fetch list of all Customer in admin section
     */
    public function getCustomer();


    /**
     * This method is to get Customer details by id
     * @param str $Id
     */
    public function getCustomerById($Id);


    /**
     * This method is to toggle Customer status
     * @param str $Id
     */
    public function toggleStatus($Id);

    /**
     * This method is to delete Customer
     * @param str $Id
     */
    public function deleteCustomer($Id);
    /**
     * This method is to search Customer
     * @param str $term
     */
    public function getSearchCustomer(string $term);




}

