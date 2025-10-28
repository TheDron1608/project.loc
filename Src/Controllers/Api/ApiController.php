<?

namespace Src\Controllers\Api;

use Src\Controllers\Controller;
use Src\Exceptions\NotFoundException;
use Src\Models\Articles\Article;

abstract class ApiController extends Controller {
    function GetTitle(): string {
        return "";
    }
    function GetDescription(): string {
        return "";
    }
}