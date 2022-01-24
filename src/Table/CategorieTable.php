<?php
namespace App\Table;

use App\Model\Categorie;
use App\Table\Exception\NotFoundException;
use \PDO;

class CategorieTable extends Table {

    protected $table = 'category' ;
    protected $class = Categorie::class ;
    
    /**
     * @param array App\Model\Post[] $posts
     * 
     * @return void
     */
    public function hydratePosts (array $posts): void
    {
        $postsById = [];
        foreach($posts as $post){
            $postsById[$post->getID()] = $post;
        }
        $keys = implode(',', array_keys($postsById));
        $categories = $this->pdo
            ->query("SELECT c.*, pc.post_id
                    FROM post_category pc
                    JOIN category c ON c.id = pc.category_id
                    WHERE pc.post_id IN ($keys)")
            ->fetchAll(PDO::FETCH_CLASS, Categorie::class);
        foreach($categories as $categorie){
            $postsById[$categorie->getPostId()]->setCategories($categorie);
        }
    }

}