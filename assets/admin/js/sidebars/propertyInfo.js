import React from 'react';
import {registerPlugin} from '@wordpress/plugins';
import {PluginDocumentSettingPanel} from '@wordpress/edit-post';
import {useSelect} from '@wordpress/data';
import {useEntityProp} from "@wordpress/core-data";

registerPlugin('rezfusion', {
  render: () => {
    const postType = useSelect(
        (select) => select('core/editor').getCurrentPostType(),
        []
    );

    if (postType !== 'vr_listing') {
      return null;
    }

    const [meta] = useEntityProp(
        'postType',
        postType,
        'meta',
    );

    const itemId = meta['rezfusion_hub_item_id'];
    const beds = meta['rezfusion_hub_beds'];
    const baths = meta['rezfusion_hub_baths'];

    return (
        <PluginDocumentSettingPanel className="rezfusion"
                                    title="Rezfusion Property Data">
          <p>{`Item ID: ${itemId}`}</p>
          <p>{`Bedrooms: ${beds}`}</p>
          <p>{`Bathrooms: ${baths}`}</p>
        </PluginDocumentSettingPanel>
    );
  }
});
