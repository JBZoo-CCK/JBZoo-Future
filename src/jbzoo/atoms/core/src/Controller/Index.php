<?php
/**
 * JBZoo CCK
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    CCK
 * @license    Proprietary http://jbzoo.com/license
 * @copyright  Copyright (C) JBZoo.com,  All rights reserved.
 * @link       http://jbzoo.com
 */

namespace JBZoo\CCK\Atom\Core\Controller;

use JBZoo\CCK\Atom\Controller;

/**
 * Class Index
 * @package JBZoo\CCK
 */
class Index extends Controller
{
    /**
     * Index action
     */
    public function index()
    {
        $this->app['assets']->add('material-ui');

        ?>
        <script>
            var WebFontConfig = {
                google: {families: ['Roboto:400,300,500:latin']}
            };
            (function () {
                var wf   = document.createElement('script');
                wf.src   = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type  = 'text/javascript';
                wf.async = 'true';
                var s    = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
            })();
        </script>
        <div id="jbzoo-react-app">Loading ...</div>
        <?php
    }
}
