import 'regenerator-runtime/runtime'
import Helper, { paths } from '../helper'

const path = paths.processors

describe(
    `[Processors] ${path}`,
    () => {
        let testProcessorId
        let initialProcessors
        let page

        beforeAll(async () => {
            page = await global.__BROWSER__.newPage()
            await Helper.login(page)
            await page.goto(Helper.url(path))
            initialProcessors = await page.$$('.wpgdprc-banner-item--processor')
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


        it("should add a data processor", async () => {
            await page.$eval(
                '[href*="/wp-admin/admin.php?page=wp-gdpr-compliance&tab=processors&new"]',
                el => el.click()
            )
            await page.waitForNavigation()
            await page.$eval('#processors_title', el => el.value = '[e2e] Test Processor')
            await page.$eval('#processors_description', el => el.value = 'Test Description')
            // TODO: Test code snippet
            await page.$eval('#processors_active', el => el.click())
            await page.$eval('#processors\\[submit\\]\\[edit\\]', el => el.click())
            await page.waitForNavigation()

            const title = await page.$eval('#processors_title', el => el.value)
            const description = await page.$eval('#processors_description', el => el.value)

            const url = new URL(page.url())
            testProcessorId = url.searchParams.get('edit')

            await page.goto(Helper.url(path))
            const currentProcessors = await page.$$('.wpgdprc-banner-item--processor')

            expect(title).toBe('[e2e] Test Processor')
            expect(description).toBe('Test Description')
            expect(currentProcessors.length).toBe(initialProcessors.length + 1)
        })

        it("should edit a data processor", async () => {
            await page.goto(Helper.url(`/wp-admin/admin.php?page=wp-gdpr-compliance&tab=processors&edit=${testProcessorId}`))
            await page.$eval('#processors_title', el => el.value = '[e2e] Test Processor Edit')
            await page.$eval('#processors_description', el => el.value = 'Test Description Edit')
            // TODO: Test code snippet
            await page.$eval('#processors\\[submit\\]\\[edit\\]', el => el.click())
            await page.waitForNavigation()

            const title = await page.$eval('#processors_title', el => el.value)
            const description = await page.$eval('#processors_description', el => el.value)

            expect(title).toBe('[e2e] Test Processor Edit')
            expect(description).toBe('Test Description Edit')
        })

        it("should delete a data processor", async () => {
            await page.goto(Helper.url(path))
            await page.evaluate(id => {
                const del = document
                    .querySelector(`[href*="/wp-admin/admin.php?page=wp-gdpr-compliance&tab=processors&edit=${id}"]`)
                    .closest('.wpgdprc-banner-item--processor')
                    .querySelector('.wpgdprc-button--delete')
                del.click()
            }, testProcessorId)
            await page.$eval(`[href*="/wp-admin/admin.php?page=wp-gdpr-compliance&tab=processors&delete=${testProcessorId}"]`, e => e.click())
            await page.waitForNavigation()

            const currentProcessors = await page.$$('.wpgdprc-banner-item--processor')
            expect(currentProcessors.length).toBe(initialProcessors.length)
        })
    }
)
