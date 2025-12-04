wp.plugins.registerPlugin('simple-body-class',{
	render(){
		const{TextControl}=wp.components;
		const{PluginDocumentSettingPanel}=wp.editPost;
		const{useSelect,useDispatch}=wp.data;
		const meta=useSelect(s=>s('core/editor').getEditedPostAttribute('meta')||{},[]);
		const{editPost}=useDispatch('core/editor');
		return wp.element.createElement(
			PluginDocumentSettingPanel,
			{name:'simple-body-class',title:'Body Class'},
			wp.element.createElement(TextControl,{
				value:meta.simple_body_class||'',
				onChange:v=>editPost({meta:{simple_body_class:v}})
			})
		);
	}
});