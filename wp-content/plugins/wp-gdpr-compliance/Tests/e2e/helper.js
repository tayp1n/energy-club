const base_url = process.env.e2e_url || 'http://saskia.dev5.van-ons.nl'

const data = {
    username: process.env.e2e_user || 'saskiavanons',
    password: process.env.e2e_password || 'Nub0hX6@IFQL'
}

const paths = {
    admin: '/wp-admin',
    dashboard: '/wp-admin/admin.php?page=wp-gdpr-compliance',
    processors: '/wp-admin/admin.php?page=wp-gdpr-compliance&tab=processors',
    settings: '/wp-admin/admin.php?page=wp-gdpr-compliance&tab=settings',
    premium: '/wp-admin/admin.php?page=wp-gdpr-compliance&tab=premium'
}

class Helper {
    static url(path) {
        return `${base_url}${path}`
    }

    static async login(page) {
        await page.goto(this.url(paths.admin))
        const cookies = await page.cookies()
        const loggedIn = cookies.filter(c => c.name.includes('wordpress_logged_in')).length > 0
        if (!loggedIn) {
            await page.$eval('#user_login', (e, data) => e.value = data.username, data)
            await page.$eval('#user_pass', (e, data) => e.value = data.password, data)
            await page.$eval('#wp-submit', e => e.click())
            await page.waitForNavigation()
        }
    }
}

export default Helper
export {
    paths,
    data
}
