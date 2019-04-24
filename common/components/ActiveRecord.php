<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/24/2019
 * Time: 8:40 AM
 */

namespace common\components;

use Yii;
use common\models\User;

class ActiveRecord extends \cnd\core\components\ActiveRecord
{
    public function canRead($userId = null)
    {
        if ($this->hasProperty('privilege')) {
            if (Yii::$app->has('user') && !Yii::$app->user->isGuest && $userId == null) {
                $userId = Yii::$app->user->identity->id;
            }
            if ($userId == null) {
                $userId = '*';
            }
            $groupId = 0;
            if (Yii::$app->user->identity->group) {
                $groupId = Yii::$app->user->identity->group->id;
            }
            return count($this->privilege) == 0 ||
                $this->isOwner ||
                $this->customCanRead() ||
                $this->adminCanRead() ||
                (!$this->isAdmin && $this->privilege['public'] == 'guest.1.1.0') ||
                (!$this->isAdmin && $this->privilege['public'] == 'guest.1.0.0') ||
                (!$this->isAdmin && $this->privilege['protected'] == 'user.*.1.1.0') ||
                (!$this->isAdmin && $this->privilege['protected'] == 'user.*.1.0.0') ||
                (!$this->isAdmin && $groupId && isset($this->privilege['groups']) && $this->privilege['groups'] == 'group.*.1.1.0') ||
                (!$this->isAdmin && $groupId && isset($this->privilege['groups']) && $this->privilege['groups'] == 'group.*.1.0.0') ||
                (!$this->isAdmin && isset($this->privilege['private']) && in_array('user.' . $userId . '.1.1.0', $this->privilege['private'])) ||
                (!$this->isAdmin && isset($this->privilege['private']) && in_array('user.' . $userId . '.1.0.0', $this->privilege['private'])) ||
                (!$this->isAdmin && isset($this->privilege['group']) && in_array('group.' . $groupId . '.1.1.0', $this->privilege['group'])) ||
                (!$this->isAdmin && isset($this->privilege['group']) && in_array('group.' . $groupId . '.1.0.0', $this->privilege['group']));
        }
        return true;
    }

    public function canWrite($userId = null)
    {
        if ($this->hasProperty('privilege')) {
            if (Yii::$app->has('user') && !Yii::$app->user->isGuest && $userId == null) {
                $userId = Yii::$app->user->identity->id;
            }
            if ($userId == null) {
                $userId = '*';
            }
            $groupId = 0;
            if (Yii::$app->user->identity->group) {
                $groupId = Yii::$app->user->identity->group->id;
            }
            return count($this->privilege) == 0 ||
                $this->isOwner ||
                $this->customCanWrite() ||
                $this->adminCanWrite() ||
                (!$this->isAdmin && $this->privilege['public'] == 'guest.1.1.0') ||
                (!$this->isAdmin && $this->privilege['public'] == 'guest.0.1.0') ||
                (!$this->isAdmin && $this->privilege['protected'] == 'user.*.1.1.0') ||
                (!$this->isAdmin && $this->privilege['protected'] == 'user.*.0.1.0') ||
                (!$this->isAdmin && $groupId && $this->privilege['groups'] == 'group.*.1.1.0') ||
                (!$this->isAdmin && $groupId && $this->privilege['groups'] == 'group.*.0.1.0') ||
                (!$this->isAdmin && isset($this->privilege['private']) && in_array('user.' . $userId . '.1.1.0', $this->privilege['private'])) ||
                (!$this->isAdmin && isset($this->privilege['private']) && in_array('user.' . $userId . '.0.1.0', $this->privilege['private'])) ||
                (!$this->isAdmin && isset($this->privilege['group']) && in_array('group.' . $groupId . '.1.1.0', $this->privilege['group'])) ||
                (!$this->isAdmin && isset($this->privilege['group']) && in_array('group.' . $groupId . '.0.1.0', $this->privilege['group']));
        }
        return true;
    }

    public static function applyPrivilege(&$query, $table = null)
    {
        if ($table == null) {
            $table = Yii::$app->db->schema->getRawTableName(static::tableName());
        }
        $q = [];
        if (!Yii::$app->user->isGuest) {
            // owner
            $q[] = $table . '.privilege like "%user.' . Yii::$app->user->identity->id . '.1.1.1%"';
            // defined user
            $q[] = $table . '.privilege like "%user.' . Yii::$app->user->identity->id . '.1.1.0%"';
            $q[] = $table . '.privilege like "%user.' . Yii::$app->user->identity->id . '.1.0.0%"';
            // defined group
            $group = Yii::$app->user->identity->group;
            if ($group) {
                $q[] = $table . '.privilege like "%group.' . $group->id . '.1.1.0%"';
                $q[] = $table . '.privilege like "%group.' . $group->id . '.1.0.0%"';
            }
            // admin
            if (in_array(Yii::$app->user->identity->type, [User::TYPE_ROOT, User::TYPE_ADMIN])) {
                $q[] = $table . '.privilege like "%admin.1.1.0%"';
                $q[] = $table . '.privilege like "%admin.1.1.0%"';
            } else {
                // loged in user
                $q[] = $table . '.privilege like "%user.*.1.0.0%"';
                $q[] = $table . '.privilege like "%user.*.1.1.0%"';

                // all group
                $q[] = $table . '.privilege like "%group.*.1.0.0%"';
                $q[] = $table . '.privilege like "%group.*.1.1.0%"';
            }
        }
        // guest
        $q[] = $table . '.privilege like "%guest.1.0.0%"';
        $q[] = $table . '.privilege like "%guest.1.1.0%"';
        $query->andWhere(implode(' OR ', $q));
    }

    public function getPrivilegeForm($form)
    {
        return Yii::$app->controller->renderFile('@common/components/views/privilege-form.php', [
            'model' => $this,
            'form' => $form,
        ]);
    }
}
