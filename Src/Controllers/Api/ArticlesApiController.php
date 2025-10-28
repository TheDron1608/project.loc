<?

namespace Src\Controllers\Api;

use Src\Exceptions\InvalidArgumentException;
use Src\Exceptions\NotFoundException;
use Src\Models\Articles\Article;

class ArticlesApiController extends ApiController {
    public function view($articleId) {
        $article = Article::getById($articleId);
        if($article === null){
            throw new NotFoundException("article not found");
        }

        $this->view->displayJSON(['article' => $article]);
    }

    public function all() {
        $articles = Article::findAll();

        $this->view->displayJSON(['articles' => $articles]);
    }

    public function delete($articleId) {
        $article = Article::getById($articleId);
        if($article === null){
            throw new NotFoundException("article not found");
        }

        $article->delete();

        $this->view->displayJSON(['success' => true]);
    }

    public function add():void{
        if (!empty($_POST)) {
            try {
                $newArticle = Article::createFromArrayNoUser($_POST);
                $success = true;
            }
            catch (InvalidArgumentException $e) {
                $success = false;
            }
        }
        else {
            $success = false;
        }
        $this->view->displayJSON(["success" => $success]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);
        if($article === null){
            throw new NotFoundException("article not found");
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        if ($input !== null) {
            try {
                $newArticle = $article->updateFromArray($input);
                $success = true;
            }
            catch (InvalidArgumentException $e) {
                $success = false;
            }
        }
        else {
            $success = false;
        }

        $this->view->displayJSON(["success" => $success, "request" => $input]);
    }
}