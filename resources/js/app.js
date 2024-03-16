import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import LinkTool from '@editorjs/link';
import RawTool from '@editorjs/raw';
import Checklist from '@editorjs/checklist';
import Embed from '@editorjs/embed';
import Quote from '@editorjs/quote';

const editor = new EditorJS({
    i18n: {
        direction: 'rtl',
    },
    holder: 'editorJS',
    placeholder: 'لورم ایپسوم',
    tools: {
        checklist: {
            class: Checklist,
            inlineToolbar: true,
        },
        quote: Quote,
        embed: Embed,
        raw: RawTool,
        header: {
            class: Header,
            inlineToolbar: true
        },
        list: {
            class: List,
            inlineToolbar: true
        },
        linkTool: {
            class: LinkTool,
            config: {
                endpoint: 'http://localhost:8000/api/fetchUrl',
            },
        }
    }
})