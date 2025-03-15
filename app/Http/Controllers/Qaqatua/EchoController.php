<?php

namespace App\Http\Controllers\Qaqatua;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\Common\PrivateKey;
use phpseclib3\Crypt\Common\PublicKey;

class EchoController extends Controller
{
    private PrivateKey $privKey;
    private PublicKey $pubKey;

    public function __construct()
    {
        $strPrivkey = "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC1FSMbd5WPw18Pq6YTAV0CIrtmJQkid+YmpIScYw5pbQvOwlAMJpeA5zZhxwlsXzHQiZODoiFKw++oQaUywN0WHZWpqxmT3IROpv52SW7zW6WD6Qf4dxs0cdUUb0WhS5pjblZrKlNNmIGegehPkakqhARVD9YzGzOx0xtKYAlk0GjamqJaZwdKwhnkj8Gl/bbi5OAeN9qjGYoWSmnNGk/arY+1BDP9Xr1xt7KnthoPSL8qGn3QlasUTq2VFLAHAwatdgC+AAc3bJnq6SSvk3xE09vUhzSz0iBJdF1Ctmsc7cSqT2qkr9FXGd3INk2rvPSbHc5sLMAUWPQ1L9QyfDEtAgMBAAECggEAFO+JrI5J22IyJmSpAb+BmlKbqfaUNMj58fPJZS9KpkO2PsRWbuEzWPLiZbGWVFI5NywAwxJGmRdIKQLV76U+qmTnPcOLZH31SgaimthonHg3DaYuhrp2ibyzbvZibYCJK//AvAkbsnf0XHgWfMSRc1nqCk+Xazc05dVLbXDnBSGlTjmwWThYNEgw63QD1dXdZpsVClYCiYsB16TDgYl9mTWilTl/iX+BWIZkNFc1sDcZUKxIeifjaOdMUoHG/AwVv7nouEVHa/P9NXLbdGCrn89xv8a2WjV2Ed9VsowVSbu4RKFw/CPhk+S6ZtW8XFYIZpANThAd0GUwduwlePGLnQKBgQDsI2ATXxdDLss0iYcXvH7wRJv02roIgBIdxqOjPPyJ47DOssccVOSCpRX2J1HL5B5i2P4Eh/+lzRgJADYOt+OxsNNSiZjhxZ/xrOEGLLQa3OfuxyJ+vXY0GsXUvSmT7UAEnOgrbMcxRc/8Atslg99lGTDW4swBkOoGiGwAeQgDawKBgQDEUEgWZqC0PgIBPc+OCxbOk3T0Z9gRmlgo4poiaw170Es/NLZ+xkaTUZ/JLjWLPXwjxBmhcNjdaszq3StXsb4inhzNsAcRZrzFp9CcfjSw9PGmmaAaYNw78N9nLa3SXGlmcFcCNtUBPriXFXWJl+v/DN/CysY1hpvvzLTQAT/bxwKBgQCFCOEFyNrYNLKy5JBBZSa2wlCCv/9y7oRGVjS2sJMuNCLWMI5QfdtHZy5aQYipr9kWo11ovB3hEQzrdTz/ScZzw0UrCO4itC4J//W+fszxHWdldLcQZDkF3dd6pR+ZgV5Buwxp+py2O7iTKCDCn+rpkCmdxqRcdYIDMDR4h7dmBQKBgGRujfKn3l9Xub7Y2G5azfgxCAxhc/DNfXytMR2alvNYxKY5WYPR/BkyEQTjVxE9C11g3ZvyF4BvOxaMv7fFfvhG24V/IJ6OaNTV3auyBVLifR42Seo003b269PlUp/kFygJIPpJAv/4Dod8uv0BdAKvm2oUQwLvMqejmn0vpnPRAoGBANFxY33biicnpm0HtNkQLw8G0rKfW1Ny4ZMQAv5b+fN/HJ5XV4aTnVR9Yf42hgKM1SM9ny6RaPeyEa9UMiXBKO2Voy08qONH/OvWLRkvrQYg+T92qn9yTMIWEz0sscol8Eb6aY/A493sNYmGomOMe1J5+pPfldHbR6XB58E/ICLg";
        $strPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtRUjG3eVj8NfD6umEwFdAiK7ZiUJInfmJqSEnGMOaW0LzsJQDCaXgOc2YccJbF8x0ImTg6IhSsPvqEGlMsDdFh2VqasZk9yETqb+dklu81ulg+kH+HcbNHHVFG9FoUuaY25WaypTTZiBnoHoT5GpKoQEVQ/WMxszsdMbSmAJZNBo2pqiWmcHSsIZ5I/Bpf224uTgHjfaoxmKFkppzRpP2q2PtQQz/V69cbeyp7YaD0i/Khp90JWrFE6tlRSwBwMGrXYAvgAHN2yZ6ukkr5N8RNPb1Ic0s9IgSXRdQrZrHO3Eqk9qpK/RVxndyDZNq7z0mx3ObCzAFFj0NS/UMnwxLQIDAQAB";

        $this->privKey = PublicKeyLoader::loadPrivateKey($strPrivkey);
        $this->pubKey = PublicKeyLoader::loadPublicKey($strPublicKey);
    }

    public function encrypt(Request $request) : JsonResponse
    {
        $input = $request->all();

        $encode = $input['payload']['a']['b'];
        $ok = openssl_public_encrypt($encode, $encrypted, $this->pubKey);
        $input['ok']=$ok;
        $input['payload']['a']['enc'] = base64_encode($encrypted);

        $response = $input;
        return response()->json($response, 200);
    }

    public function decrypt(Request $request) : JsonResponse
    {
        $input = $request->all();

        $decoded = base64_decode($input['payload']['a']['b']);
        openssl_private_decrypt($decoded, $decrypted, $this->privKey);
        $input['payload']['a']['b'] = $decrypted;
        $response = $input;

        return response()->json($response, 201);
    }

}
