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
  name: '',
  averageRtp: '',
  biggestWinMonth: '',
  paymentDelayHours: '',
  monthlyWithdrawalLimit: '',
  validatedWithdrawalsValue: '',
  monthlyWithdrawalsNumber: '',
  cta_text: '',
  cta: '',
};

registerBlockType('casino-cards/statistics-card', {
  apiVersion: API_VERSION,
  title: __('Statistics Card', TEXT_DOMAIN),
  description: __('Select casino and optionally override values.', TEXT_DOMAIN),
  category: BLOCK_CATEGORY,
  icon: 'chart-bar',

  attributes: {
    casinoId: { type: 'string',  default: '' },
    overrides: { type: 'object', default: defaultOverrides },
  },

  edit: (props) => {
    const {attributes, setAttributes} = props;
    const {casinoId, overrides} = attributes;

    const blockProps = useBlockProps();

    const [ loading, setLoading ] = useState(true);
    const [ error, setError ] = useState('');
    const [ casinos, setCasinos ] = useState([]);
    const [ draft, setDraft ] = useState(overrides);
    const [ fieldErrors, setFieldErrors ] = useState({});

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

    const onNumberChange = (field, value) => {
      const raw = value ?? '';
      setDraft((prev) => ({...prev, [field]: raw}));

      const v = raw.trim();

      if (v === '') {
        setFieldErrors((prev) => ({...prev, [field]: ''}));
        setOverrideValue(field, '');
        return;
      }

      const normalized = v.replace(',', '.');

      if (! /^[0-9]+(\.[0-9]+)?$/.test(normalized)) {
        setFieldErrors((prev) => ({...prev, [field]: __('Must be a number.', TEXT_DOMAIN)}));
        return;
      }

      setFieldErrors((prev) => ({...prev, [field]: ''}));
      setOverrideValue(field, v);
    };

    const onTextChange = (field, value) => {
      const raw = value ?? '';
      setDraft((prev) => ({...prev, [field]: raw}));
      setOverrideValue(field, raw.trim());
    };

    const restoreAll = () => {
      setFieldErrors({});
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
                className={ fieldErrors.averageRtp ? 'casino-cards-field--invalid' : '' }
                label={ __('Average RTP', TEXT_DOMAIN) }
                value={ draft.averageRtp }
                onChange={ (value) => onNumberChange('averageRtp', value) }
                help={ fieldErrors.averageRtp || undefined }
                __nextHasNoMarginBottom
              />

              <TextControl
                className={ fieldErrors.biggestWinMonth ? 'casino-cards-field--invalid' : '' }
                label={ __('Biggest win/month', TEXT_DOMAIN) }
                value={ draft.biggestWinMonth }
                onChange={ (value) => onNumberChange('biggestWinMonth', value) }
                help={ fieldErrors.biggestWinMonth || undefined }
                __nextHasNoMarginBottom
              />

              <TextControl
                className={ fieldErrors.paymentDelayHours ? 'casino-cards-field--invalid' : '' }
                label={ __('Payment delay (hours)', TEXT_DOMAIN) }
                value={ draft.paymentDelayHours }
                onChange={ (value) => onNumberChange('paymentDelayHours', value) }
                help={ fieldErrors.paymentDelayHours || undefined }
                __nextHasNoMarginBottom
              />

              <TextControl
                className={ fieldErrors.monthlyWithdrawalLimit ? 'casino-cards-field--invalid' : '' }
                label={ __('Monthly withdrawal limit', TEXT_DOMAIN) }
                value={ draft.monthlyWithdrawalLimit }
                onChange={ (value) => onNumberChange('monthlyWithdrawalLimit', value) }
                help={ fieldErrors.monthlyWithdrawalLimit || undefined }
                __nextHasNoMarginBottom
              />

              <TextControl
                className={ fieldErrors.validatedWithdrawalsValue ? 'casino-cards-field--invalid' : '' }
                label={ __('Validated withdrawals value', TEXT_DOMAIN) }
                value={ draft.validatedWithdrawalsValue }
                onChange={ (value) => onNumberChange('validatedWithdrawalsValue', value) }
                help={ fieldErrors.validatedWithdrawalsValue || undefined }
                __nextHasNoMarginBottom
              />

              <TextControl
                className={ fieldErrors.monthlyWithdrawalsNumber ? 'casino-cards-field--invalid' : '' }
                label={ __('Monthly withdrawals number', TEXT_DOMAIN) }
                value={ draft.monthlyWithdrawalsNumber }
                onChange={ (value) => onNumberChange('monthlyWithdrawalsNumber', value) }
                help={ fieldErrors.monthlyWithdrawalsNumber || undefined }
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
                  onChange={ (value) => {
                    if (value === casinoId) return;
                    setFieldErrors({});
                    setDraft(defaultOverrides);
                    setAttributes({casinoId: value, overrides: defaultOverrides});
                  } }
                  __nextHasNoMarginBottom
                />
              </>
            ) }
          </div>

          { casinoId ? (
            <div className="casino-cards-editor-preview">
              <Disabled>
                <ServerSideRender block="casino-cards/statistics-card" attributes={ attributes }/>
              </Disabled>
            </div>
          ) : null }
        </div>
      </>
    );
  },

  save: () => null,
});
