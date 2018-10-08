<?php

namespace TractorCow\Fluent\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\DataList;
use TractorCow\Fluent\State\FluentState;

/**
 * Available since SilverStripe 4.3.x
 */
class FluentReadVersionsExtension extends Extension
{
    /**
     * Set a filter on the current locale in SourceLocale alias field. This field is added by
     * FluentExtension::augmentSQL, and this list is used in the history viewer via a GraphQL query.
     *
     * @param DataList &$list
     */
    public function updateList(DataList &$list)
    {
        if (Injector::inst()->get($list->dataClass())->hasExtension(FluentVersionedExtension::class)) {
            return;
        }

        $locale = FluentState::singleton()->getLocale();

        $query = $list->dataQuery();
        $query->having(['"SourceLocale" = ?' => $locale]);

        $list = $list->setDataQuery($query);
    }
}
