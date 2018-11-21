<?php

    namespace App\Inspections;

    class Spam {

        protected $inspections = [

            InvalidKeywords::class,
            KeyHoldDown::class

        ];

        public function detect($body)
        {
            foreach($this->inspections as $inspection)
            {

                app($inspection)->detect($body);

            }

            return false;
        }

    }