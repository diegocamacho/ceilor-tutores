<?php
namespace XmlSchemaValidator;

class LibXmlException extends SchemaValidatorException
{
    /**
     * Checks for errors in libxml, if found clear the errors and chain all the error messages
     *
     * @throws LibXmlException when found a libxml error
     */
    public static function throwFromLibXml()
    {
        $errors = libxml_get_errors();
        if (count($errors)) {
            libxml_clear_errors();
        }
        $lastException = null;
        /** @var \LibXMLError $error */
        foreach ($errors as $error) {
            $current = new self($error->message, 0, $lastException);
            $lastException = $current;
        }
        if (null !== $lastException) {
            throw $lastException;
        }
    }

    /**
     * Execute a callable ensuring that the execution will occur inside an environment
     * where libxml use internal errors is true.
     *
     * After executing the callable the value of libxml use internal errors is set to
     * previous value.
     *
     * @param callable $callable
     * @return mixed
     *
     * @throws LibXmlException if some error inside libxml was found
     */
    public static function useInternalErrors(callable $callable)
    {
        $previousLibXmlUseInternalErrors = libxml_use_internal_errors(true);
        if ($previousLibXmlUseInternalErrors) {
            libxml_clear_errors();
        }
        $return = $callable();
        try {
            static::throwFromLibXml();
        } finally {
            libxml_use_internal_errors($previousLibXmlUseInternalErrors);
        }
        return $return;
    }
}
