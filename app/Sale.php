<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    const PENDING = 0;
    const RELEASED = 1;
    const VOIDED = 2;
    const DECLINED = 3;

    protected $guarded = [];

    protected $with = ['payment', 'shippingDetail', 'user'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders')->using('App\Order')->withPivot([
            'quantity',
            'price',
            'discount'
        ]);
    }

    public function shippingDetail()
    {
        return $this->hasOne(ShippingDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setSubtotalAttribute($value)
    {
        return $this->attributes['subtotal'] = number_format($value, 2, '.', '');
    }

    public function setShippingAttribute($value)
    {
        return $this->attributes['shipping'] = number_format($value, 2, '.', '');
    }

    public function setFeesAttribute($value)
    {
        return $this->attributes['fees'] = number_format($value, 2, '.', '');
    }

    public function setDiscountAttribute($value)
    {
        return $this->attributes['discount'] = number_format($value, 2, '.', '');
    }

    public function setTotalAttribute($value)
    {
        return $this->attributes['total'] = number_format($value, 2, '.', '');
    }

    public function getMember()
    {
        return $this->user ? "{$this->user->info->first_name} {$this->user->info->last_name}" : 'Non member';
        //return $this->user ? "{$this->user->info->first_name} {$this->user->info->last_name}" : 'Non member';
       //$name= isset($this->user) ? "{$this->user->info->first_name} {$this->user->info->last_name}" : "{$this->shippingDetail->first_name}";
       /*$name= isset($this->shippingDetail) ? "{$this->shippingDetail->first_name}" : "{$this->user->info->first_name} {$this->user->info->last_name}";
       return $name;*/
        //return $this->user ? "Member" : 'Non member';
        //return $this->user ? "{$this->user->info->first_name} {$this->user->info->last_name}" : "{$this->shipping_details->first_name}";
        //return $this->user ? "{$this->user->info->first_name} {$this->user->info->last_name}" : "{$this->shippingDetail->first_name}";
        //if(!empty($this->user)){
        //    return "{$this->user->info->first_name} {$this->user->info->last_name}";
        //}else{
        //    return "{$this->shippingDetail->first_name}";
        //}
        
    }
    
    public function getType()
    {
        //return $this->user ? "{$this->user->info->first_name} {$this->user->info->last_name}" : 'Non member';
        return $this->user ? "Member" : 'Non member';
        //return $this->user ? "{$this->user->info->first_name} {$this->user->info->last_name}" : "{$this->shipping_details->first_name}";
    }

    public function getShippingDetails()
    {
        return $this->ship_to_another_address == 1 ? "Yes" : "No";
    }

    public function getStatusDetails()
    {
        return $this->products_released == self::RELEASED ? "Released":( $this->products_released == self::VOIDED ? "Voided" : ( $this->products_released == self::DECLINED ? "Declined" : "Pending"));
    }

    public function getPaymentStatus()
    {
        return $this->payment->is_paid == Payment::PAID ? "Yes" : ( $this->payment->is_paid == Payment::REFUNDED ? "Refunded" : "No");
    }

    public function getGatewayStatus()
    {
        return $this->payment->status == Payment::PROCESSED ? "Processed" : ( $this->payment->status == Payment::DECLINED ? "Declined" : "Error");
    }

    public function getInvoiceName()
    {
        return $this->user ? "{$this->user->info->first_name} {$this->user->info->last_name}" :
            "{$this->shippingDetail->first_name} {$this->shippingDetail->last_name}";
    }

    public function getInvoiceNumber()
    {
        return $this->payment->confirmation_number;
    }

    public function getUsername()
    {
        return $this->user ? $this->user->username:'Non member';
    }

    public function getEmail()
    {
        return $this->user ? $this->user->email:$this->shippingDetail->email;
    }

    public function getInvoiceAddress()
    {
        if($this->user){
            $city = $this->capitalizeFirst(City::where('citymunCode', $this->user->info->city_id)->first()->citymunDesc);
            $province = $this->capitalizeFirst(Province::where('provCode', $this->user->info->province_id)->first()->provDesc);
            return "{$this->user->info->address}, $city, $province";
        }
        $city = $this->capitalizeFirst($this->shippingDetail->city);
        $province = $this->capitalizeFirst($this->shippingDetail->province);

        return  "{$this->shippingDetail->street_address}, $city, $province";
    }

    private function capitalizeFirst($str) {
        return ucwords(strtolower($str));
    }
}
