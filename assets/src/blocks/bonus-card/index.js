import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { SelectControl, TextControl, Button, Spinner, Notice, PanelBody, Disabled } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { useEffect, useMemo, useState } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';

import apiFetch from '@wordpress/api-fetch';

import { TEXT_DOMAIN, BLOCK_CATEGORY, API_VERSION } from '../constants';
import './styles.editor.scss';

const defaultOverrides = {
  ctaText: '',
  cta: '',
  bonusTitle: '',
  bonusDescription: '',
};

registerBlockType('casino-cards/bonus-card', {
  apiVersion: API_VERSION,
  title: __('Bonus Card', TEXT_DOMAIN),
  description: __('Select casino and optionally override values.', TEXT_DOMAIN),
  category: BLOCK_CATEGORY,
  icon: 'tickets-alt',
  attributes: {
    casinoId: {type: 'string', default: ''},
    overrides: {type: 'object', default: defaultOverrides}
  },

  edit: (props) => {
    const {attributes, setAttributes} = props;
    const {casinoId, overrides} = attributes;

    const blockProps = useBlockProps();

    const [ loading, setLoading ] = useState(true);
    const [ error, setError ] = useState('');
    const [ casinos, setCasinos ] = useState([]);
    const [ draft, setDraft ] = useState(overrides);

    useEffect(() => {
      apiFetch({path: '/casino-cards/v1/casinos'})
        .then((res) => {
          const list = res && res.success && Array.isArray(res.data) ? res.data : [];
          setCasinos(list);
          setError('');
        })
        .catch(() => {
          setError(__('Failed to load casinos list from API.', TEXT_DOMAIN));
        })
        .finally(() => setLoading(false));
    }, []);

    const options = useMemo(() => {
      const base = [ {label: '—', value: ''} ];
      return base.concat(casinos.map((casino) => ({label: casino.name, value: casino.id})));
    }, [ casinos ]);

    const setOverrideValue = (field, value) => {
      setAttributes({
        overrides: {
          ...overrides,
          [field]: value,
        },
      });
    };

    const onTextChange = (field, value) => {
      const raw = value ?? '';
      setDraft((prev) => ({...prev, [field]: raw}));
      setOverrideValue(field, raw.trim());
    };

    const restoreAll = () => {
      setAttributes({
        overrides: defaultOverrides,
      });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={ __('Overrides (optional)', TEXT_DOMAIN) } initialOpen={ true }>
            <div style={ {display: 'flex', justifyContent: 'flex-end', marginBottom: 8} }>
              <Button
                variant="link"
                onClick={ restoreAll }
                style={ {padding: 0, height: 'auto', lineHeight: 1.2, fontSize: 12} }
              >
                { __('Restore all', TEXT_DOMAIN) }
              </Button>
            </div>

            <div style={ {display: 'grid', rowGap: 2} }>
              <TextControl
                label={ __('Bonus Title', TEXT_DOMAIN) }
                value={ draft.bonusTitle }
                onChange={ (value) => onTextChange('bonusTitle', value) }
                __nextHasNoMarginBottom
              />

              <TextControl
                label={ __('Bonus Description', TEXT_DOMAIN) }
                value={ draft.bonusDescription }
                onChange={ (value) => onTextChange('bonusDescription', value) }
                __nextHasNoMarginBottom
              />

              <TextControl
                label={ __('CTA Text', TEXT_DOMAIN) }
                value={ draft.ctaText }
                onChange={ (value) => onTextChange('ctaText', value) }
                __nextHasNoMarginBottom
              />

              <TextControl
                label={ __('CTA (URL)', TEXT_DOMAIN) }
                value={ draft.cta }
                onChange={ (value) => onTextChange('cta', value) }
                __nextHasNoMarginBottom
              />
            </div>
          </PanelBody>
        </InspectorControls>

        <div { ...blockProps }>
          <div className="casino-cards-editor-select">
            { loading ? (
              <Spinner/>
            ) : (
              <>
                { error ? (
                  <Notice status="error" isDismissible={ false }>
                    { error }
                  </Notice>
                ) : null }
  
                <SelectControl
                  label={ __('Select casino', TEXT_DOMAIN) }
                  value={ casinoId }
                  options={ options }
                  onChange={ (value) => setAttributes({casinoId: value, overrides: defaultOverrides}) }
                  __nextHasNoMarginBottom
                />
              </>
            ) }
          </div>
        
          { casinoId ? (
            <div className="casino-cards-editor-preview">
              <Disabled>
                <ServerSideRender block="casino-cards/bonus-card" attributes={ attributes }/>
              </Disabled>
            </div>
          ) : null }
        </div>
      </>
    );
  },

  save: () => null,
});
