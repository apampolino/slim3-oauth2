<?php

namespace App\Extensions;

use Twig_Extension;
use Slim\Csrf\Guard;

class CsrfExtension extends \Twig_Extension
{

    /**
     * @var \Slim\Csrf\Guard
     */
    protected $guard;
    
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function getGlobals()
    {
        // CSRF token name and value
        $csrfNameKey = $this->guard->getTokenNameKey();
        $csrfValueKey = $this->guard->getTokenValueKey();
        $csrfName = $this->guard->getTokenName();
        $csrfValue = $this->guard->getTokenValue();

        return [
            'csrf' => [
                'field' => '
                    <input type="hidden" name="'. $csrfNameKey .'" value="'. $csrfName .'" />
                    <input type="hidden" name="'. $csrfValueKey .'" value="'. $csrfValue .'" />'
            ]
        ];
    }

    public function getName()
    {
        return 'slim/csrf';
    }
}