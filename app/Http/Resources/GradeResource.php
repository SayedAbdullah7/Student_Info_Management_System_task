<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
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
            'enrollment_id' => $this->enrollment_id,
            'grade_item_id' => $this->grade_item_id,
            'grade' => $this->grade,
            'enrollment' => new EnrollmentResource($this->whenLoaded('enrollment')),
            'grade_item' => new GradeItemResource($this->whenLoaded('gradeItem')),
        ];
    }
}
