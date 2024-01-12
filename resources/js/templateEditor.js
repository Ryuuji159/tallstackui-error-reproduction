import {basicSetup} from "codemirror"
import {EditorView, keymap} from "@codemirror/view"
import {indentWithTab} from "@codemirror/commands"
import {php} from "@codemirror/lang-php"

export default (initialText) => ({
    theme:  EditorView.theme({
        "&": {height: "90vh", border: '1px solid #e5e7eb'},
        ".cm-scroller": {overflow: "auto"},
        ".cm-content, .cm-gutter": {minHeight: "90vh"}
    }),
    editor: null,

    init() {
        this.editor = new EditorView({
            extensions: [
                basicSetup,
                php(),
                keymap.of([indentWithTab]),
                this.theme,
                EditorView.lineWrapping,
                EditorView.updateListener.of(update => {
                    if(update.docChanged) {
                        this.parseText();
                    }
                })
            ],
            parent: document.getElementById('editor'),
            doc: initialText
        })

        this.parseText()
    },

    parseText() {
        const data = this.editor.state.doc.toString();
        this.$wire.set('mjml', data);
    }
})

