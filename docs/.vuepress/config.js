import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'

export default defineUserConfig({
    bundler: viteBundler(),
    theme: defaultTheme(),

    base: '/documentation',
    lang: 'en-US',
    title: 'Qaqatua',
    description: 'An enc/dec echo server, usefully for QA testing',

    dest: `./public/documentation`,

    head: [['link', { rel: 'icon', href: '/qaqatua.png' }]],
})
