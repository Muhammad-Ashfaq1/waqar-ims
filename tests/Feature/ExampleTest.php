<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('togglePassword');
    $response->assertSee('fa-eye');
});

