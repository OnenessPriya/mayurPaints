<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function listAll();
    public function getSearchProducts($category,$keyword);
    public function categoryList();
    public function listById($id);
    public function listBySlug($slug);
    public function relatedProducts($id);
    public function create(array $data);
    public function update($id, array $data);
    public function toggle($id);
    public function delete($id);
    public function deleteSingleImage($id);
    
}
