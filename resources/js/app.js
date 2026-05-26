import './bootstrap';
import Alpine from 'alpinejs';
import { initTopicCopyButtons } from './topic-copy';

window.Alpine = Alpine;
Alpine.start();

initTopicCopyButtons();
