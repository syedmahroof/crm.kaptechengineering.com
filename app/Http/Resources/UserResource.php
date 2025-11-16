<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->whenNotNull($this->deleted_at),
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name');
            }),
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->getAllPermissions()->pluck('name');
            }),
            'branches' => $this->whenLoaded('branches', function () {
                return $this->branches->map(function ($branch) {
                    return [
                        'id' => $branch->id,
                        'name' => $branch->name,
                        'code' => $branch->code,
                        'is_primary' => $branch->pivot->is_primary,
                    ];
                });
            }),
            'primary_branch' => $this->whenLoaded('branches', function () {
                $primaryBranch = $this->branches->where('pivot.is_primary', true)->first();
                return $primaryBranch ? [
                    'id' => $primaryBranch->id,
                    'name' => $primaryBranch->name,
                    'code' => $primaryBranch->code,
                ] : null;
            }),
        ];
    }
}
