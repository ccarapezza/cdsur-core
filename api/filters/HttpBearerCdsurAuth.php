<?php
namespace api\filters;

use yii\filters\auth\HttpBearerAuth;

/**
 * HTTP Bearer Authenticator Custon for CDSUR API
 *
 * @author Christian Carapezza <carapezza.christian@gmail.com>
 */
class HttpBearerCdsurAuth extends HttpBearerAuth
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('cdsur-token');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $identity = $user->loginByAccessToken($matches[1], get_class($this));
            if ($identity === null) {
                $this->handleFailure($response);
            }

            return $identity;
        }

        return null;
    }
}
