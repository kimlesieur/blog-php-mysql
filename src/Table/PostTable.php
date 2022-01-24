<?php
namespace App\Table;
use App\PaginatedQuery;
use App\Model\Post;
use App\Model\Categorie;
use \PDO;

class PostTable extends Table {

    protected $table = "post";
    protected $class = Post::class;

    public function update($post): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug, content = :content, created_at = :created WHERE id = :id");
        $ok = $query->execute(
            [
            'id' => $post->getId(), 
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created' => $post->getCreatedAt()->format('Y-m-d H:i:s')
            ]);
        if($ok === false){
            throw new \Exception("Impossible de mettre à jour l'article id#{$post->getId()} dans la table {$this->table}");
        }
    }

    public function create($post): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name = :name, slug = :slug, content = :content, created_at = :created");
        $ok = $query->execute(
            [
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created' => $post->getCreatedAt()->format('Y-m-d H:i:s')
            ]);
        if($ok === false){
            throw new \Exception("Impossible de créer l'article {$post->getName()} dans la table {$this->table}");
        }
        $post->setId($this->pdo->lastInsertId());
    }
    
    public function findPaginated() 
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategorieTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    
    public function findPaginatedForCategory (int $categoryID)
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.* 
            FROM {$this->table} p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}"
        );

        $posts = $paginatedQuery->getItems(Post::class);
        (new CategorieTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function delete(int $id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if($ok === false){
            throw new \Exception("Impossible de supprimer $id dans la table {$this->table}");
        }
    }

}