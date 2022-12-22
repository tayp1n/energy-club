import 'regenerator-runtime/runtime.js'

import init from './utils/init'
import animations from './components/animations'
import Message from './components/message'
import Tabs from './components/tabs'
import Expand from './components/expand'

// Utilities
import ExtendCodeMirror from './utils/codemirror'

// Admin scripts
import BannerItems from './admin/banner-item'
import ConsentBarForm from './admin/consent-bar-form'
import IntegrationsForm from './admin/integrations-form'
import PremiumModeForm from './admin/premium-form'
import PrivacyPolicyForm from './admin/privacy-policy-form'
import RequestOverview from './admin/request-overview'
import RequestUserForm from './admin/request-user-form'
import ResetConsent from './admin/reset-consent'
import SettingsForm from './admin/settings-form'
import Wizard from './admin/wizard'
import SignUpModal from './admin/sign-up-modal'
import ComparisonSlider from './admin/comparison-slider'

/**
 * When using FontAwesome via Javascript
 * import fontAwesome from './components/fontAwesome';
 */

// On Document ready
init(() => {
    animations()
    /**
     * When using FontAwesome via javascript
     * fontAwesome();
     */

    // Utilities here...
    const mirror = new ExtendCodeMirror()
    const premiumForm = new PremiumModeForm()

    // Add other components here...
    new Message()
    new Tabs()

    // Add Admin components here...
    new BannerItems()
    new Expand()
    new ConsentBarForm()
    new IntegrationsForm()
    new PrivacyPolicyForm()
    new RequestUserForm()
    new RequestOverview()
    new ResetConsent()
    new SettingsForm()
    new ComparisonSlider()

    new SignUpModal(premiumForm)
    new Wizard(mirror)
})
