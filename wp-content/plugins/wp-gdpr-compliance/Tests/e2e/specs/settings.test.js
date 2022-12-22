import 'regenerator-runtime/runtime'
import Helper, { paths } from '../helper'

const path = paths.settings

describe(
    `[Settings] ${path}`,
    () => {
        let page
        beforeAll(async () => {
            page = await global.__BROWSER__.newPage()
            await Helper.login(page)
            await page.goto(Helper.url(path))
        })

        test.each([
            '.wpgdprc-header',
            '.wpgdprc-sidebar',
            '.wpgdprc-content',
            '.wpgdprc-footer'
        ])("should show the %s element", async (element) => {
            const el = await page.$(element)
            expect(el).toBeTruthy()
        })
    }
)
