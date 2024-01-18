<!-- Prayoga Ajitya Setiawan 2211500331 -->
<?php
function XML2Array_2211500331(SimpleXMLElement $parent)
{
    $array = array();
    foreach ($parent as $name => $element) {
        ($node = & $array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = & $node[];
        $node = $element->count() ? XML2Array_2211500331($element) : trim($element);
    }
    return $array;
}
?>