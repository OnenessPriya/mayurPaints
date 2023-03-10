<?php

namespace App\Interfaces;

interface PainterInterface
{
    
    /**
     * This method is to fetch list of all painter in admin section
     */
    public function getPainter();


    /**
     * This method is to get category details by id
     * @param str $Id
     */
    public function getPainterById($Id);


    /**
     * This method is to toggle Painter status
     * @param str $Id
     */
    public function toggleStatus($Id);

     /**
     * This method is to approve Painter status
     * @param str $Id
     */
    public function toggleApprove($Id);

    /**
     * This method is to delete category
     * @param str $Id
     */
    public function deletePainter($Id);

    public function getSearchPainter(string $term);




}

