<?

namespace Src\Controllers\Api;

use Src\Models\Users\User;

class UsersApiController extends ApiController {
    public function getEmailIsUnique($email) {
        $this->view->displayJSON(['result' => !User::hasAnyByColumn("email", $email)]);
    }
    public function getLoginIsUnique($login) {
        $this->view->displayJSON(['result' => !User::hasAnyByColumn("login", $login)]);
    }
}