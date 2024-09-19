<?php

class JWTCodec {

    public function encode(array $payload): string {
        
        $header = json_encode([
            "typ" => "JWT",
            "alg" => "HS256"
        ]);
        $header = $this->base64urlEncode($header);

        $payload = json_encode($payload);
        $payload = $this->base64urlEncode($payload);

        $signature = hash_hmac("sha256", 
                                $header . "." . $payload,
                                "XaGKjbTSbPl2tXKH4a4EEPmuxvRvvRJ/xComHiOZTZcegBkZZewP7HplzrhYs7YPUKOL3Dl02+LMKNY0TAdGGreMsE0AkQAFChdGoTg53x3LfJEraZPR4t2b1ASM4CcLXvUKlXgW8NQCLlHPhVAuOo4TUjG5qhgnnqmrVkrjZH6Ns1d+q5G4qbtTEKz2JMqLfryN0/z2/NMAJ7X3w6yKnIkb1/Xs4idRm8uG9Dl1Ka8O/VT9cpnGp0yDyCftr5xd4jLrbCEamWqU9KThVaBxfpvhDD2kIwM2O/gpsBp8sMy3o92yosJ2eeILYdCiadQ7DXiy7y4G05TXZpOZ57It9qzhmxAA4GfllMDqSo10L6g=",
                                true);

        $signature = $this->base64urlEncode($signature);

        return $header . "." . $payload . "." . $signature;

    }

    private function base64urlEncode(string $text): string {

        return str_replace(
            ["+" , "/" , "="], 
            ["-", "_", ""], 
            base64_encode($text));
    }
}