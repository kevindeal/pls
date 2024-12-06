import { registerBlockType } from '@wordpress/blocks';

registerBlockType('my-theme/my-block', {
  title: 'My Block',
  category: 'widgets',
  edit: () => <div>Hello, this is my block!</div>,
  save: () => <div>Hello, this is my block!</div>,
});
