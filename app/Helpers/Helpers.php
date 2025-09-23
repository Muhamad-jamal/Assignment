<?php

    use Symfony\Component\HttpFoundation\Response;

    if (!function_exists('jsonResponse')) {
        function jsonResponse(
            int               $status = Response::HTTP_OK,
            string            $message = '',
            object|array|null $data = null,
            object|array|null $extraData = null,
            array             $errors = [],
            array             $meta = [],
            array             $dynamicKeys = []
        ): Response
        {
            $content = [];
            if ($message) {
                $content['message'] = $message;
            }
            if ($data) {
                $content['data'] = $data;
            }
            if ($extraData) {
                $content['extraData'] = $extraData;
            }
            if ($errors) {
                $content['errors'] = $errors;
            }
            if ($meta) {
                $content['meta'] = $meta;
            }

            foreach ($dynamicKeys as $key => $value) {
                $content[$key] = $value;
            }

            return !empty($content) ? response($content, $status) : response(status: $status);
        }
    }


    
