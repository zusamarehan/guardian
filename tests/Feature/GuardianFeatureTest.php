<?php

use Illuminate\Support\Str;
use RehanKanak\Guardian\Models\Guardian;

test('it can generate a guardian for authentication', function () {
    $response = $this->postJson(route('guardian.generate'), [
        'resourceId' => Str::uuid(),
    ]);

    $response->assertStatus(201);
});

test('it can respond', function () {
    $resourceId = Str::uuid();
    $generateGuardian = $this->postJson(route('guardian.generate'), [
        'resourceId' => $resourceId,
    ]);

    $generateGuardian->assertStatus(201);

    $generateRespond = $this->postJson(route('guardian.respond'), [
        'resourceId' => $resourceId,
        'response' => 'Laravel-Guardian',
    ]);

    $generateRespond->assertStatus(200);
});

test('it can check the status', function () {
    $resourceId = Str::uuid();
    // generate
    $generateGuardian = $this->postJson(route('guardian.generate'), [
        'resourceId' => $resourceId,
    ]);

    $generateGuardian->assertStatus(201);

    // respond
    $generateRespond = $this->postJson(route('guardian.respond'), [
        'resourceId' => $resourceId,
        'response' => 'Laravel-Guardian',
    ]);

    $generateRespond->assertStatus(200);
    // status
    $generateStatus = $this->postJson(route('guardian.status'), [
        'resourceId' => $resourceId,
    ]);

    $generateStatus->assertStatus(200);

});

test('it will return -1 when the user has not responded yet', function () {
    $resourceId = Str::uuid();
    // generate
    $generateGuardian = $this->postJson(route('guardian.generate'), [
        'resourceId' => $resourceId,
    ]);
    $generateGuardian->assertStatus(201);

    // status
    $generateStatus = $this->postJson(route('guardian.status'), [
        'resourceId' => $resourceId,
    ]);

    $generateStatus->assertExactJson([
        'status' => -1,
    ]);
});

test('it will return 0 when the user has responded incorrectly', function () {
    $resourceId = Str::uuid();
    // generate
    $generateGuardian = $this->postJson(route('guardian.generate'), [
        'resourceId' => $resourceId,
    ]);

    $generateGuardian->assertStatus(201);

    // respond
    $generateRespond = $this->postJson(route('guardian.respond'), [
        'resourceId' => $resourceId,
        'response' => 'Laravel-Guardian',
    ]);

    $generateRespond->assertStatus(200);
    // status
    $generateStatus = $this->postJson(route('guardian.status'), [
        'resourceId' => $resourceId,
    ]);

    $generateStatus->assertExactJson([
        'status' => 0,
    ]);
});

test('it will return 1 when the user has responded correctly', function () {
    $resourceId = Str::uuid();
    // generate
    $generateGuardian = $this->postJson(route('guardian.generate'), [
        'resourceId' => $resourceId,
    ]);

    $generateGuardian->assertStatus(201);

    $guardian = Guardian::query()
        ->where('resource_uuid', $resourceId)
        ->where('is_valid', true)
        ->first();

    // respond
    $generateRespond = $this->postJson(route('guardian.respond'), [
        'resourceId' => $resourceId,
        'response' => $guardian->right_option,
    ]);

    $generateRespond->assertStatus(200);
    // status
    $generateStatus = $this->postJson(route('guardian.status'), [
        'resourceId' => $resourceId,
    ]);

    $generateStatus->assertExactJson([
        'status' => 1,
    ]);
});

test('it will invalidate the previous guardian, when new guardian is requested', function () {
    $resourceId = Str::uuid();
    // generate
    $generateGuardian = $this->postJson(route('guardian.generate'), [
        'resourceId' => $resourceId,
    ]);

    $generateGuardian->assertStatus(201);

    $guardian = Guardian::query()
        ->where('resource_uuid', $resourceId)
        ->where('is_valid', true)
        ->first();

    // generate
    $generateGuardian = $this->postJson(route('guardian.generate'), [
        'resourceId' => $resourceId,
    ]);

    $generateGuardian->assertStatus(201);

    $guardian = Guardian::find($guardian->id);

    expect($guardian->is_valid)->toBe(false);

});
