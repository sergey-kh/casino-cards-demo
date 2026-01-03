<?php
/**
 * @var \TestProject\CasinoCards\Api\Dto\Casino $casino
 * @var array $overrides
 */

$textDomain = \TestProject\CasinoCards\Config\PluginConfig::TEXT_DOMAIN;
$pluginUrl = \TestProject\CasinoCards\Bootstrap::$pluginUrl;
?>
<div class="casino-cards-bonus-card" data-casino-id="<?php echo esc_attr($casino->id); ?>">
    <div class="casino-cards-bonus-card__inner">
        <div class="casino-cards-bonus-card__character" aria-hidden="true">
            <img src="<?php echo esc_url($pluginUrl . 'assets/img/bonus-card.png'); ?>"
                 alt="<?php echo esc_attr($casino->bonusTitle); ?>">
        </div>
        <div class="casino-cards-bonus-card__content">
            <div class="casino-cards-bonus-card__title">
                <?php echo esc_html($casino->bonusTitle); ?>
            </div>

            <?php if (! empty($casino->bonusDescription)) : ?>
                <div class="casino-cards-bonus-card__description">
                    <?php echo esc_html($casino->bonusDescription); ?>
                </div>
            <?php endif; ?>

            <?php if (! empty($casino->cta)) : ?>
                <div class="casino-cards-bonus-card__cta">
                    <a
                        class="casino-cards-bonus-card__button"
                        href="<?php echo esc_url($casino->cta); ?>"
                        rel="nofollow noopener"
                    >
                        <?php echo ! empty($overrides['ctaText'])
                            ? esc_html($overrides['ctaText'])
                            : esc_html(__('Claim Bonus', $textDomain)); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
