<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class Mahmut
{
    protected $request;
    protected $falanFilan;

    public function __construct(Request $request, $falanFilan)
    {
        $this->falanFilan = $falanFilan;
        $this->request = $request;
    }

    public function konus()
    {
        return __(':falanfilan : Abi şu an buradasın :BURASI',
            [
                'BURASI' => $this->request->route()->getName(),
                'falanfilan' => $this->falanFilan,
            ]);
    }

}
