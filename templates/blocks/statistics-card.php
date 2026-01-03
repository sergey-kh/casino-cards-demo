<?php
/**
 * @var \TestProject\CasinoCards\Api\Dto\Casino $casino
 * @var array $overrides
 */

$textDomain = \TestProject\CasinoCards\Config\PluginConfig::TEXT_DOMAIN;
?>

<div class="casino-cards-statistics-card" data-casino-id="<?php echo esc_attr($casino->id); ?>">
    <div class="casino-cards-statistics-card__inner">
        <div class="casino-cards-statistics-card__brand">
            <?php if ($casino->logoUrl !== '') : ?>
                <img
                    class="casino-cards-statistics-card__brand-logo"
                    src="<?php echo esc_url($casino->logoUrl); ?>"
                    alt="<?php echo esc_attr($casino->name); ?>"
                    loading="lazy"
                    decoding="async"
                >
            <?php else : ?>
                <div class="casino-cards-statistics-card__brand-name">
                    <?php echo esc_html($casino->name); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="casino-cards-statistics-card__stats">
            <div class="casino-cards-statistics-card__stat">
                <span class="casino-cards-statistics-card__icon" aria-hidden="true">
                    <?php /* phpcs:disable Generic.Files.LineLength */ ?>
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                        <path d="M7.5 0C3.36 0 0 3.36 0 7.5S3.36 15 7.5 15 15 11.64 15 7.5 11.64 0 7.5 0Zm-1.94 3.97c.87 0 1.47.72 1.47 1.56s-.63 1.56-1.47 1.56c-.88 0-1.47-.72-1.47-1.56s.59-1.56 1.47-1.56Zm-.23 7c-.41 0-.65-.47-.41-.8l4.26-5.83a.5.5 0 0 1 .41-.22c.41 0 .65.47.41.8L5.75 10.76a.5.5 0 0 1-.41.22Zm4.1.06c-.88 0-1.47-.72-1.47-1.56s.63-1.56 1.47-1.56c.87 0 1.47.72 1.47 1.56s-.6 1.56-1.47 1.56Z"/>
                    </svg>
                </span>
                <div class="casino-cards-statistics-card__stat-text">
                    <div class="casino-cards-statistics-card__label">
                        <?php echo esc_html(__('Average RTP', $textDomain)); ?>
                    </div>
                    <div class="casino-cards-statistics-card__value">
                        <?php echo esc_html((string) $casino->averageRtp); ?>%
                    </div>
                </div>
            </div>
            <div class="casino-cards-statistics-card__stat">
                <span class="casino-cards-statistics-card__icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                        <path d="M12.8021 2.1979C9.87181 -0.732393 5.12863 -0.732833 2.19793 2.1979C-0.732389 5.12816 -0.732858 9.87139 2.19793 12.8021C5.12822 15.7324 9.8714 15.7328 12.8021 12.8021C15.7324 9.87183 15.7329 5.1286 12.8021 2.1979ZM6.24863 5.94557C6.58878 5.94557 6.86453 6.22132 6.86453 6.56147C6.86453 6.90162 6.58878 7.17737 6.24863 7.17737H5.00862C4.98056 7.39774 4.98044 7.60134 5.00862 7.8226H6.24863C6.58878 7.8226 6.86453 8.09834 6.86453 8.43849C6.86453 8.77864 6.58878 9.05439 6.24863 9.05439H5.52653C6.47261 10.2507 8.2273 10.3258 9.27656 9.27658C9.51711 9.03606 9.90703 9.03606 10.1476 9.27658C10.3881 9.5171 10.3881 9.90708 10.1476 10.1476C8.31881 11.9764 5.18401 11.4464 4.0917 9.05439H3.4331C3.09295 9.05439 2.8172 8.77864 2.8172 8.43849C2.8172 8.09834 3.09295 7.8226 3.4331 7.8226H3.76961C3.75172 7.61161 3.75046 7.40302 3.76961 7.17737H3.4331C3.09295 7.17737 2.8172 6.90162 2.8172 6.56147C2.8172 6.22132 3.09295 5.94557 3.4331 5.94557H4.0917C5.17574 3.57173 8.30631 3.01112 10.1476 4.85239C10.3881 5.09291 10.3881 5.48286 10.1476 5.72338C9.90706 5.9639 9.51708 5.9639 9.27656 5.72338C8.22718 4.67401 6.47246 4.74944 5.52653 5.94557H6.24863Z"/>
                    </svg>
                </span>
                <div class="casino-cards-statistics-card__stat-text">
                    <div class="casino-cards-statistics-card__label">
                        <?php echo esc_html(__('Biggest win/month', $textDomain)); ?>
                    </div>
                    <div class="casino-cards-statistics-card__value">
                        <?php echo esc_html((string) $casino->biggestWinMonth); ?> €
                    </div>
                </div>
            </div>
            <div class="casino-cards-statistics-card__stat">
                <span class="casino-cards-statistics-card__icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                        <path d="M7.5 0C3.35762 0 0 3.35762 0 7.5C0 11.6424 3.35762 15 7.5 15C11.6424 15 15 11.6424 15 7.5C15 3.35762 11.6424 0 7.5 0ZM8.1988 7.571H8.16144C8.16144 7.72048 8.0867 7.87182 8.01196 7.98393L5.0355 10.9604C4.92339 11.0725 4.77205 11.1099 4.6207 11.1099C4.46936 11.1099 4.31988 11.0351 4.20777 10.9212C4.01906 10.6969 4.05643 10.3569 4.28251 10.1308L6.91891 7.4944C7.03102 7.38229 7.07025 7.26831 7.07025 7.11883V2.2216C7.07025 1.92078 7.33371 1.65732 7.63453 1.65732C7.93535 1.65732 8.1988 1.92078 8.1988 2.2216V7.571Z"/>
                    </svg>
                </span>
                <div class="casino-cards-statistics-card__stat-text">
                    <div class="casino-cards-statistics-card__label">
                        <?php echo esc_html(__('Payment delay', $textDomain)); ?>
                    </div>
                    <div class="casino-cards-statistics-card__value">
                        <?php echo esc_html((string) $casino->paymentDelayHours); ?>
                        <?php echo esc_html(' ' . __('Hours', $textDomain)); ?>
                    </div>
                </div>
            </div>
            <div class="casino-cards-statistics-card__stat">
                <span class="casino-cards-statistics-card__icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.50919 15C11.6285 15 15 11.6327 15 7.5C15 3.36735 11.6285 0 7.50919 0C3.38987 0 0 3.36735 0 7.5C0 11.6327 3.37148 15 7.50919 15Z" fill="currentColor"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0339 10.3054L8.69469 8.95464V9.64171H7.65067C6.55955 9.64171 5.64898 8.73603 5.64898 7.62736C5.64898 6.51868 6.55955 5.613 7.65067 5.613C8.74179 5.613 9.67591 6.51868 9.67591 7.62736H11.0339C11.0339 5.79257 9.51892 4.28571 7.65067 4.28571C5.78243 4.28571 4.29097 5.79257 4.29097 7.62736C4.31452 9.46214 5.80598 10.969 7.65067 10.969H8.69469V11.6326L11.0339 10.3054Z" fill="#FFFFFF"/>
                    </svg>
                </span>
                <div class="casino-cards-statistics-card__stat-text">
                    <div class="casino-cards-statistics-card__label">
                        <?php echo esc_html(__('Monthly Withdrawal', $textDomain)); ?>
                    </div>
                    <div class="casino-cards-statistics-card__value">
                        <?php echo esc_html((string) $casino->monthlyWithdrawalLimit); ?> €
                    </div>
                </div>
            </div>
            <div class="casino-cards-statistics-card__stat">
                <span class="casino-cards-statistics-card__icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M7.5 15C11.6421 15 15 11.6421 15 7.5C15 3.35786 11.6421 0 7.5 0C3.35786 0 0 3.35786 0 7.5C0 11.6421 3.35786 15 7.5 15Z" fill="currentColor"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2367 6.10135C11.2303 6.1082 11.2238 6.11505 11.2172 6.12173L6.90295 10.4359C6.81071 10.5282 6.69951 10.5913 6.58134 10.6251C6.32445 10.7018 6.03218 10.6402 5.83199 10.44L3.28417 7.8922C2.9948 7.60277 2.99214 7.12366 3.28417 6.83157C3.57626 6.53954 4.05277 6.53948 4.34486 6.83151L6.36508 8.85173L10.6554 4.56137C10.9475 4.26928 11.4256 4.27094 11.716 4.56137C12.0064 4.8518 12.0065 5.33157 11.7161 5.622L11.2367 6.10135Z" fill="#FFFFFF"/>
                    </svg>
                </span>
                <div class="casino-cards-statistics-card__stat-text">
                    <div class="casino-cards-statistics-card__label">
                        <?php echo esc_html(__('Validated withdrawals', $textDomain)); ?>
                    </div>
                    <div class="casino-cards-statistics-card__value">
                        <?php echo esc_html((string) $casino->validatedWithdrawalsValue); ?> €
                    </div>
                </div>
            </div>
            <div class="casino-cards-statistics-card__stat">
                <span class="casino-cards-statistics-card__icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                        <path d="M7.5 0C6.01664 0 4.5666 0.439867 3.33323 1.26398C2.09986 2.08809 1.13856 3.25943 0.570907 4.62987C0.00324965 6.00032 -0.145275 7.50832 0.144114 8.96318C0.433503 10.418 1.14781 11.7544 2.1967 12.8033C3.2456 13.8522 4.58197 14.5665 6.03683 14.8559C7.49168 15.1453 8.99968 14.9968 10.3701 14.4291C11.7406 13.8614 12.9119 12.9001 13.736 11.6668C14.5601 10.4334 15 8.98336 15 7.5C15 5.51088 14.2098 3.60322 12.8033 2.1967C11.3968 0.790176 9.48913 0 7.5 0ZM9.96032 12.3313H5.03969C4.87393 12.3313 4.71496 12.2654 4.59775 12.1482C4.48054 12.031 4.41469 11.872 4.41469 11.7063C4.41469 11.5405 4.48054 11.3815 4.59775 11.2643C4.71496 11.1471 4.87393 11.0813 5.03969 11.0813H9.96032C10.1261 11.0813 10.285 11.1471 10.4023 11.2643C10.5195 11.3815 10.5853 11.5405 10.5853 11.7063C10.5853 11.872 10.5195 12.031 10.4023 12.1482C10.285 12.2654 10.1261 12.3313 9.96032 12.3313ZM10.4022 7.63L7.94 10.0938C7.8228 10.2109 7.66386 10.2767 7.49813 10.2767C7.3324 10.2767 7.17346 10.2109 7.05625 10.0938L4.59782 7.63563C4.48037 7.51843 4.4143 7.35939 4.41412 7.19348C4.41395 7.02757 4.47969 6.86838 4.59688 6.75094C4.71407 6.6335 4.87312 6.56742 5.03903 6.56724C5.20494 6.56707 5.36413 6.63281 5.48157 6.75L6.875 8.14344V2.61406C6.875 2.4483 6.94085 2.28933 7.05806 2.17212C7.17527 2.05491 7.33424 1.98906 7.5 1.98906C7.66576 1.98906 7.82474 2.05491 7.94195 2.17212C8.05916 2.28933 8.125 2.4483 8.125 2.61406V8.13969L9.51844 6.74625C9.63632 6.6324 9.79419 6.56941 9.95807 6.57083C10.1219 6.57225 10.2787 6.63798 10.3946 6.75386C10.5105 6.86974 10.5762 7.0265 10.5776 7.19037C10.579 7.35425 10.516 7.51212 10.4022 7.63Z"/>
                    </svg>
                </span>
                <div class="casino-cards-statistics-card__stat-text">
                    <div class="casino-cards-statistics-card__label">
                        <?php echo esc_html(__('Number of monthly withdrawals', $textDomain)); ?>
                    </div>
                    <div class="casino-cards-statistics-card__value">
                        <?php echo esc_html((string) $casino->monthlyWithdrawalsNumber); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if (! empty($casino->cta)) : ?>
            <div class="casino-cards-statistics-card__cta">
                <a class="casino-cards-statistics-card__button" href="<?php echo esc_url($casino->cta); ?>">
                    <?php echo ! empty($overrides['ctaText'])
                        ? esc_html($overrides['ctaText'])
                        : esc_html(__('Play Now', $textDomain)); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
