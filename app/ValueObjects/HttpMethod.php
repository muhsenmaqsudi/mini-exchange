<?php

namespace App\ValueObjects;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 */
enum HttpMethod: string
{
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/CONNECT */
    case CONNECT = 'CONNECT';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE */
    case DELETE = 'DELETE';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET */
    case GET = 'GET';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD */
    case HEAD = 'HEAD';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS */
    case OPTIONS = 'OPTIONS';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH */
    case PATCH = 'PATCH';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST */
    case POST = 'POST';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT */
    case PUT = 'PUT';
    /** @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/TRACE */
    case TRACE = 'TRACE';
}
