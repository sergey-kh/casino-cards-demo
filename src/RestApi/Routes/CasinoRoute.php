<?php

namespace TestProject\CasinoCards\RestApi\Routes;

use Exception;
use TestProject\CasinoCards\Api\Dto\CasinoListItem;
use TestProject\CasinoCards\Api\Factory\CasinoProviderFactory;
use TestProject\CasinoCards\Api\HttpClient;
use TestProject\CasinoCards\Foundation\Interfaces\RouteInterface;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * CasinoRoute class
 */
class CasinoRoute implements RouteInterface
{
    private const NAMESPACE = 'casino-cards/v1';

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return self::NAMESPACE;
    }

    /**
     * @return array[]
     */
    public function getRoutes(): array
    {
        // TODO: Improve authorization for rest-api endpoints
        return [
            'casinos' => [
                'methods' => 'GET',
                'callback' => [$this, 'getCasinos'],
                'permission_callback' => [$this, 'permissionCallback'],
                'args' => [],
            ],
        ];
    }

    /**
     * @param WP_REST_Request $request
     * @return bool
     */
    public function permissionCallback(WP_REST_Request $request): bool
    {
        return current_user_can('edit_posts');
    }

    /**
     * @return WP_Error|WP_REST_Response
     */
    public function getCasinos(): WP_Error|WP_REST_Response
    {
        try {
            $casinoFactory = new CasinoProviderFactory(new HttpClient());
            $provider = $casinoFactory->create('cartable');
            $items = $provider->getCasinoList();
            $data = array_map(
                static fn(CasinoListItem $item) => $item->toArray(),
                $items
            );

            return new WP_REST_Response(['success' => true, 'data' => $data]);
        } catch (Exception $e) {
            return new WP_Error('casino_cards_casinos_failed', 'Failed to fetch casinos list.', [
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
