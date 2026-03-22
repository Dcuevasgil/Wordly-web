<?php

namespace App\Modules\Auth\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    public function toArray($request) {
        
        return [
            'id_users' => $this->id_users,
            
            'name' => $this->id_users,
            
            'email' => $this->id_users,
            
            'role' => $this->id_users,
            
            'is_user_active' => $this->id_users,
            
            'last_access' => $this->id_users,
        ];
    
    }

};


