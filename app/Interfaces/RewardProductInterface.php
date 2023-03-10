<?php

namespace App\Interfaces;

interface RewardProductInterface
{
    public function listAll();
    public function getSearchProducts($keyword);
    public function listById($id);
    public function listBySlug($slug);
    public function create(array $data);
    public function update($id, array $data);
    public function toggle($id);
    public function delete($id);
    
}
