<?php

test('halaman utama mengarahkan pengguna ke login', function () {
    $this->get('/')
        ->assertRedirect(route('login'));
});
