<?php

namespace Tests\Feature;

use App\Models\Key;
use App\Models\Order;
use App\Models\Technician;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OrderPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_index_page_is_success()
    {
        $response = $this->get(route('orders.index'));

        $response->assertStatus(200);
    }

    public function test_create_order_is_success()
    {
        $key = Key::factory()->create();
        $vehicle = Vehicle::factory()->create();
        DB::table('key_vehicle')->insert([
            'key_id' => $key->id,
            'vehicle_id' => $vehicle->id,
        ]);
        $technician = Technician::factory()->create();

        $response = $this->post('/orders', [
            'key' => $key->id,
            'vehicle' => $vehicle->id,
            'technician' => $technician->id,
        ]);

        $response->assertRedirect(route('orders.index'));
    }

    public function test_validation_is_success()
    {
        $key = Key::factory()->create();
        $vehicle = Vehicle::factory()->create();
        DB::table('key_vehicle')->insert([
            'key_id' => $key->id,
            'vehicle_id' => $vehicle->id,
        ]);
        $technician = Technician::factory()->create();

        $response = $this->post('/orders', [
            'key' => $key->id,
            'technician' => $technician->id,
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_order_edit_page_is_success()
    {
        $keyOrigin = Key::factory()->create();
        $vehicleOrigin = Vehicle::factory()->create();
        DB::table('key_vehicle')->insert([
            'key_id' => $keyOrigin->id,
            'vehicle_id' => $vehicleOrigin->id,
        ]);
        $technicianOrigin = Technician::factory()->create();
        $order = Order::create([
            'key_id' => $keyOrigin->id,
            'vehicle_id' => $vehicleOrigin->id,
            'technician_id' => $technicianOrigin->id,
        ]);

        $response = $this->get("/orders/" . $order->id . "/edit");

        $response->assertStatus(200);
    }

    public function test_update_order_is_success()
    {
        $keyOrigin = Key::factory()->create();
        $vehicleOrigin = Vehicle::factory()->create();
        DB::table('key_vehicle')->insert([
            'key_id' => $keyOrigin->id,
            'vehicle_id' => $vehicleOrigin->id,
        ]);
        $technicianOrigin = Technician::factory()->create();
        $order = Order::create([
            'key_id' => $keyOrigin->id,
            'vehicle_id' => $vehicleOrigin->id,
            'technician_id' => $technicianOrigin->id,
        ]);
        
        $keyNew = Key::factory()->create();
        $vehicleNew = Vehicle::factory()->create();
        DB::table('key_vehicle')->insert([
            'key_id' => $keyNew->id,
            'vehicle_id' => $vehicleNew->id,
        ]);
        $technicianNew = Technician::factory()->create();

        $response = $this->put('/orders/' . $order->id, [
            'key' => $keyNew->id,
            'vehicle' => $vehicleNew->id,
            'technician' => $technicianNew->id,
        ]);

        $response->assertRedirect(route('orders.index'));
    }

    public function test_delete_order_is_success()
    {
        $keyOrigin = Key::factory()->create();
        $vehicleOrigin = Vehicle::factory()->create();
        DB::table('key_vehicle')->insert([
            'key_id' => $keyOrigin->id,
            'vehicle_id' => $vehicleOrigin->id,
        ]);
        $technicianOrigin = Technician::factory()->create();
        $order = Order::create([
            'key_id' => $keyOrigin->id,
            'vehicle_id' => $vehicleOrigin->id,
            'technician_id' => $technicianOrigin->id,
        ]);

        $response = $this->delete(route('orders.destroy', $order->id));

        $response->assertRedirect(route('orders.index'));
    }

    public function test_get_vehicles_ajax_is_success()
    {
        $keyOrigin = Key::factory()->create();
        $vehicleOrigin = Vehicle::factory()->create();
        DB::table('key_vehicle')->insert([
            'key_id' => $keyOrigin->id,
            'vehicle_id' => $vehicleOrigin->id,
        ]);

        $response = $this->get('/orders/getVehiclesByKey/' . $keyOrigin->id);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'year',
                'make',
                'model',
                'vin',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
