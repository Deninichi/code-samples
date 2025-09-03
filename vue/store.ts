import { defineStore } from 'pinia';
import { computed, ref } from 'vue';
import { useAuthStore } from '@/stores/auth.store';
import api from '@/api/axios';

export interface Webhook {
  id: number;
  name: string;
  url: string;
  secret?: string;
  events: string[];
  is_active: boolean;
  last_webhook_call?: {
    uuid: string;
    status: string;
    response_code: number;
    created_at: string;
  } | null;
  webhook_calls?: WebhookCall[];
  created_at: string;
  updated_at: string;
}

export interface WebhookCall {
  id: number;
  uuid: string;
  name: string;
  url: string;
  headers: Record<string, string>;
  payload: any;
  exception?: string;
  status: string;
  response_code: number | null;
  response_body?: string;
  attempt: number;
  meta: any[];
  tags: any[];
  created_at: string;
  updated_at: string;
}

export interface CreateWebhookPayload {
  name: string;
  url: string;
  secret?: string;
  events?: string[];
  is_active?: boolean;
}

export interface UpdateWebhookPayload {
  name?: string;
  url?: string;
  secret?: string;
  events?: string[];
  is_active?: boolean;
}

export const useWebhooksStore = defineStore('Webhooks', () => {
  const authStore = useAuthStore();

  const webhooks = ref<Webhook[]>([]);
  const total = ref(0);
  const isLoading = ref(false);
  const error = ref<string | null>(null);

  const activeWebhooks = computed(() =>
    webhooks.value.filter(webhook => webhook.is_active)
  );

  const inactiveWebhooks = computed(() =>
    webhooks.value.filter(webhook => !webhook.is_active)
  );

  async function fetchWebhooks(params?: {
    search?: string;
    is_active?: boolean;
    sort_by?: string;
    sort_order?: 'asc' | 'desc';
    per_page?: number;
  }) {
    isLoading.value = true;
    error.value = null;
    try {
      const response = await api.get<{
        data: Webhook[];
        pagination: {
          current_page: number;
          per_page: number;
          total: number;
          total_pages: number;
        };
        message: string;
      }>(`/teams/${authStore.teamId}/webhooks`, { params });

      webhooks.value = response.data.data;
      total.value = response.data.pagination.total;

      return {
        webhooks: response.data.data,
        pagination: response.data.pagination,
      };
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch webhooks';
      return {
        webhooks: [] as Webhook[],
        pagination: {
          current_page: 1,
          per_page: 15,
          total: 0,
          total_pages: 1,
        },
      };
    } finally {
      isLoading.value = false;
    }
  }

  async function createWebhook(payload: CreateWebhookPayload) {
    isLoading.value = true;
    error.value = null;
    try {
      const response = await api.post<{ data: Webhook; message: string }>(
        `/teams/${authStore.teamId}/webhooks`,
        payload
      );
      webhooks.value.push(response.data.data);
      return response.data.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to create webhook';
      throw err;
    } finally {
      isLoading.value = false;
    }
  }

  async function updateWebhook(webhookId: number, payload: UpdateWebhookPayload) {
    isLoading.value = true;
    error.value = null;

    try {
      const response = await api.put<{ data: Webhook; message: string }>(
        `/teams/${authStore.teamId}/webhooks/${webhookId}`,
        payload
      );

      const index = webhooks.value.findIndex(w => w.id === webhookId);
      if (index !== -1) {
        webhooks.value[index] = response.data.data;
      }

      return response.data.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to update webhook';
      throw err;
    } finally {
      isLoading.value = false;
    }
  }

  async function deleteWebhook(webhookId: number) {
    isLoading.value = true;
    error.value = null;

    try {
      await api.delete(`/teams/${authStore.teamId}/webhooks/${webhookId}`);
      webhooks.value = webhooks.value.filter(w => w.id !== webhookId);
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to delete webhook';
      throw err;
    } finally {
      isLoading.value = false;
    }
  }

  async function testWebhook(webhookId: number) {
    isLoading.value = true;
    error.value = null;

    try {
      const response = await api.post<{ message: string; payload: any }>(
        `/teams/${authStore.teamId}/webhooks/${webhookId}/test`
      );
      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to test webhook';
      throw err;
    } finally {
      isLoading.value = false;
    }
  }

  async function getWebhookCalls(webhookId: number, params?: {
    status?: string;
    search?: string;
    sort_by?: string;
    sort_order?: 'asc' | 'desc';
    per_page?: number;
  }) {
    isLoading.value = true;
    error.value = null;

    try {
      const response = await api.get<{
        data: WebhookCall[];
        pagination: {
          current_page: number;
          per_page: number;
          total: number;
          total_pages: number;
        };
        message: string;
      }>(`/teams/${authStore.teamId}/webhooks/${webhookId}/calls`, { params });

      return response.data;
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Failed to fetch webhook calls';
      throw err;
    } finally {
      isLoading.value = false;
    }
  }

  return {
    webhooks,
    total,
    isLoading,
    error,
    activeWebhooks,
    inactiveWebhooks,
    fetchWebhooks,
    createWebhook,
    updateWebhook,
    deleteWebhook,
    testWebhook,
    getWebhookCalls,
  };
});
