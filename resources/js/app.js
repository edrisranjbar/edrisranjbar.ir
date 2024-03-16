import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import LinkTool from '@editorjs/link';

const editor = new EditorJS({
    i18n: {
        direction: 'rtl',
    },
    holder: 'editorJS',
    placeholder: 'لورم ایپسوم',
    tools: {
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