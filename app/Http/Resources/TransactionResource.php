<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'transaction_date' => (string)$this->transaction_date,
            'state_id' => (int)$this->state_id,
            'state' => (string)$this->State->name,
            'num_private_transport' => (int)$this->num_private_transport,
            'price_private_transport' => (double)$this->price_private_transport,
            'num_taxi_motorbike' => (int)$this->num_taxi_motorbike,
            'price_taxi_motorbike' => (double)$this->price_taxi_motorbike,
            'num_private_without_exam' => (int)$this->num_private_without_exam,
            'price_private_without_exam' => (double)$this->price_private_without_exam,
            'num_permissions_data' => (int)$this->num_permissions_data,
            'price_permissions_data' => (double)$this->price_permissions_data,
            'num_driving' => (int)$this->num_driving,
            'price_driving' => (double)$this->price_driving,
            'expenses' => (double)$this->expenses,

        ];
    }
}
