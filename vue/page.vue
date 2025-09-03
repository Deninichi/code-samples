<script setup lang="ts">
import { onMounted, ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useWebhooksStore } from "@/stores/webhooks.store";
import WebhookItem from "./components/WebhookItem.vue";
import CreateWebhookDialog from "./components/CreateWebhookDialog.vue";

const webhooksStore = useWebhooksStore();
const toast = useToast();

const createDialogVisible = ref(false);

onMounted(async () => {
  await webhooksStore.fetchWebhooks();
});

const handleCreateWebhook = async (webhookData: any) => {
  try {
    await webhooksStore.createWebhook(webhookData);
    createDialogVisible.value = false;
    toast.add({ severity: "success", summary: "Webhook created", life: 3000 });
  } catch (error: any) {
    toast.add({ 
      severity: "error", 
      summary: "Failed to create webhook", 
      detail: error.response?.data?.message || "An error occurred",
      life: 5000 
    });
  }
};

const handleDeleteWebhook = async (webhookId: number) => {
  try {
    await webhooksStore.deleteWebhook(webhookId);
    toast.add({ severity: "success", summary: "Webhook deleted", life: 3000 });
  } catch (error: any) {
    toast.add({
      severity: "error",
      summary: "Failed to delete webhook",
      detail: error.response?.data?.message || "An error occurred",
      life: 5000
    });
  }
};

const handleTestWebhook = async (webhookId: number) => {
  try {
    await webhooksStore.testWebhook(webhookId);
    toast.add({ severity: "success", summary: "Test webhook sent", life: 3000 });
  } catch (error: any) {
    toast.add({
      severity: "error",
      summary: "Failed to test webhook",
      detail: error.response?.data?.message || "An error occurred",
      life: 5000
    });
  }
};
</script>

<template>
  <div class="page">
    <section class="page-heading">
      <div class="page-heading__head">
        <h1>Webhooks</h1>
        <p>Manage webhooks to receive real-time notifications about your projects and floorplans</p>
      </div>
      <Button
        label="Create Webhook"
        icon="pi pi-plus"
        @click="createDialogVisible = true"
        class="custom-button"
        :disabled="webhooksStore.isLoading"
      />
    </section>

    <section class="webhooks-list">
      <ProgressSpinner v-if="webhooksStore.isLoading" />
      
      <div v-else-if="!webhooksStore.webhooks.length" class="empty-state">
        <i class="pi pi-link" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
        <h3>No webhooks found</h3>
        <p>Create your first webhook to start receiving real-time notifications</p>
        <Button
          label="Create Webhook"
          icon="pi pi-plus"
          @click="createDialogVisible = true"
          class="custom-button"
        />
      </div>

      <div v-else class="webhooks-grid">
        <div v-for="webhook in webhooksStore.webhooks" :key="webhook.id">
          <WebhookItem 
            :webhook="webhook"
            @delete="handleDeleteWebhook"
            @test="handleTestWebhook"
          />
        </div>
      </div>
    </section>

    <CreateWebhookDialog
      v-model:visible="createDialogVisible"
      @create="handleCreateWebhook"
    />
  </div>
</template>

<style scoped>
.page-heading {
  margin-bottom: 2rem;
  display: flex;
  justify-content: space-between;
  gap: 2rem;
  align-items: flex-start;
}

.page-heading__head h1 {
  margin-bottom: 0.5rem;
  font-size: 2rem;
  font-weight: 700;
}

.page-heading__head p {
  color: #666;
  margin: 0;
}

.custom-button {
  padding-left: 1rem;
  padding-right: 1rem;
}



.webhooks-list {
  min-height: 200px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.empty-state {
  text-align: center;
  padding: 3rem;
  color: #666;
}

.empty-state h3 {
  margin-bottom: 0.5rem;
  color: #333;
}

.empty-state p {
  margin-bottom: 1.5rem;
}

.webhooks-grid {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  width: 100%;
}

@media (max-width: 768px) {
  .page-heading {
    flex-direction: column;
    gap: 1rem;
  }

  .filters-row {
    flex-direction: column;
    align-items: stretch;
  }

  .search-container {
    max-width: none;
  }

  .webhooks-grid {
    grid-template-columns: 1fr;
  }
}
</style>
