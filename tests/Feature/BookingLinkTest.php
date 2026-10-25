<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookingLinkTest extends TestCase
{
    public function test_book_buttons_open_whatsapp_chat_with_tania(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="https://wa.me/27663421732?text=', false)
            ->assertDontSee('href="#contact"', false);
    }

    public function test_training_button_sends_a_training_enquiry(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="https://wa.me/27663421732?text='.rawurlencode("Hi Tania, I'd like to know more about your lash training courses.").'"', false);
    }

    public function test_facebook_page_is_linked(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="https://www.facebook.com/taniassweet/"', false);
    }
}
