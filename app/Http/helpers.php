<?php
function checkPermission($permissions){
    $userAccess = getMyPermission(auth()->user()->is_permission);
    foreach ($permissions as $key => $value) {
        if($value == $userAccess){
            return true;
        }
    }
    return false;
}

function getMyPermission($id){
    switch ($id) {
        case 'admin':
            return 'admin';
            break;
        case 'superadmin':
            return 'superadmin';
            break;

        default:
            return 'user';
            break;
    }
}
